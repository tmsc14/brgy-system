<?php

namespace App\Http\Controllers\Auth;

use App\Models\AccessCode;
use App\Models\AppearanceSetting;
use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\BarangayCaptain;
use App\Models\BarangayOfficial; 
use App\Models\Staff;            
use App\Models\Resident;
use App\Models\Role;
use App\Models\User;
use App\Models\TurnoverRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\SignupRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Feature;
use App\Models\BarangayFeatureSetting;
use Illuminate\Support\Facades\DB;

class BarangayCaptainController extends Controller
{
    public function showStep1()
    {
        return view('auth.barangay_captain.bc-signup-step1');
    }

    public function postStep1(Request $request)
    {
        $request->validate([
            'region' => 'required',
            'province' => 'required',
            'city_municipality' => 'required',
            'barangay' => 'required',
        ]);

        session([
            'region' => $request->region,
            'province' => $request->province,
            'city_municipality' => $request->city_municipality,
            'barangay' => $request->barangay,
        ]);

        return redirect()->route('barangay_captain.register.step2');
    }

    public function showStep2()
    {
        return view('auth.barangay_captain.bc-signup-step2');
    }

    public function postStep2(Request $request)
    {
        $request->validate([
            'first_name' => 'required|alpha_spaces|min:2|max:50',
            'middle_name' => 'nullable|alpha_spaces|min:2|max:50',
            'last_name' => 'required|alpha_spaces|min:2|max:50',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'email' => [
                'required',
                'email',
                Rule::unique('barangay_captains', 'email'),
                Rule::unique('barangay_officials', 'email'),
                Rule::unique('barangay_staff', 'email'),
                Rule::unique('barangay_residents', 'email'),
                Rule::unique('barangays', 'barangay_email'),
            ],
            'contact_no' => [
                'required',
                'digits_between:10,15',
                Rule::unique('barangay_captains', 'contact_no'),
                Rule::unique('barangay_officials', 'contact_no'),
                Rule::unique('barangay_staff', 'contact_no'),
                Rule::unique('barangay_residents', 'contact_no'),
                Rule::unique('barangays', 'barangay_contact_number'),
            ],
        ]);
    
        session([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
        ]);
    
        return redirect()->route('barangay_captain.register.step3');
    }    
    
    public function showStep3()
    {
        return view('auth.barangay_captain.bc-signup-step3');
    }

    public function postStep3(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ],
            'access_code' => 'required|exists:access_codes,code',
        ]);
    
        // Create the Barangay Captain
        $user = BarangayCaptain::create([
            'region' => session('region'),
            'province' => session('province'),
            'city_municipality' => session('city_municipality'),
            'barangay' => session('barangay'),
            'first_name' => session('first_name'),
            'middle_name' => session('middle_name'),
            'last_name' => session('last_name'),
            'date_of_birth' => session('date_of_birth'),
            'gender' => session('gender'),
            'email' => session('email'),
            'contact_no' => session('contact_no'),
            'password' => Hash::make($request->password),
        ]);
    
        // Create the role without barangay_id initially
        Role::create([
            'user_id' => $user->id,
            'barangay_id' => null, // This will be updated once the barangay is created
            'role_type' => 'barangay_captain',
            'active' => true,
        ]);
    
        // Clear session data
        session()->flush();
    
        return redirect()->route('barangay_captain.login')->with('success', 'Registration successful! Please log in.');
    }       
    
    public function showTurnover()
    {
        $user = Auth::guard('barangay_captain')->user();
    
        // Fetch the barangay details and active role for the current Barangay Captain
        $barangay = $user->barangayDetails;
        $activeRole = $user->activeRole;
    
        // Get the list of other potential barangay captains in the same location
        $potentialCaptains = BarangayCaptain::where('region', $user->region)
            ->where('province', $user->province)
            ->where('city_municipality', $user->city_municipality)
            ->where('barangay', $user->barangay)
            ->where('id', '!=', $user->id)
            ->get();
    
        $appearanceSettings = $user->appearanceSettings;
    
        return view('barangay_captain.settings.bc-turnover', compact('user', 'barangay', 'activeRole', 'potentialCaptains', 'appearanceSettings'));
    }       

    public function initiateTurnover(Request $request)
    {
        $currentUser = Auth::guard('barangay_captain')->user();
        $newCaptain = BarangayCaptain::findOrFail($request->input('new_captain_id'));
    
        // Deactivate the current Barangay Captain's role
        $currentUser->activeRole()->update(['active' => false]);
    
        // Assign the new Barangay Captain role
        $newCaptain->roles()->create([
            'barangay_id' => $currentUser->barangayDetails->id,
            'role_type' => 'barangay_captain',
            'active' => true,
        ]);
    
        // Update the barangay's captain_id
        $currentUser->barangayDetails->update(['barangay_captain_id' => $newCaptain->id]);

        // Transfer the appearance settings to the new Barangay Captain
        $appearanceSettings = $currentUser->appearanceSettings;
        if ($appearanceSettings) {
            $appearanceSettings->update(['barangay_captain_id' => $newCaptain->id]);
        }
    
        // Logout the current Barangay Captain
        Auth::guard('barangay_captain')->logout();
    
        return redirect()->route('barangay_captain.login')->with('success', 'Turnover process completed successfully.');
    }           
    
    //optional - currently not being used.
    public function revokeAccess($id)
    {
        $role = Role::findOrFail($id);
        $role->active = false;
        $role->save();

        return redirect()->route('barangay_captain.dashboard')->with('success', 'Access revoked successfully.');
    }

    public function showPendingTurnover()
    {
        $user = Auth::guard('barangay_captain')->user();

        return view('auth.barangay_captain.pending-turnover', compact('user'));
    }
    
    public function showLogin()
    {
        return view('auth.barangay_captain.bc-login');
    }

    public function login(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        // Check if the user exists based on email
        $user = BarangayCaptain::where('email', $credentials['email'])->first();
    
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Invalidate any previous session
            Auth::guard('barangay_captain')->logout(); // Log out previous user if any
            session()->invalidate();  // Invalidate the session
            session()->regenerateToken(); // Regenerate CSRF token for security
    
            // Check for active role in the roles table
            $activeRole = $user->roles()->where('active', true)->where('role_type', 'barangay_captain')->first();
    
            if ($activeRole) {
                // Check if the user's barangay exists
                $existingBarangay = Barangay::where('region', $user->region)
                    ->where('province', $user->province)
                    ->where('city', $user->city_municipality)
                    ->where('barangay', $user->barangay)
                    ->first();
    
                if ($existingBarangay && $existingBarangay->barangay_captain_id != $user->id) {
                    // Redirect to the placeholder view if the barangay already exists with another captain
                    return redirect()->route('barangay_captain.pending_turnover');
                }
    
                if ($existingBarangay && $existingBarangay->barangay_captain_id == $user->id) {
                    // Redirect to the dashboard if the barangay already exists with this captain
                    Auth::guard('barangay_captain')->login($user);
                    session()->regenerate(); // Generate a new session ID for the new user
                    return redirect()->intended(route('bc-dashboard'));
                }
    
                // No barangay found, redirect to create barangay info
                Auth::guard('barangay_captain')->login($user);
                session()->regenerate(); // Generate a new session ID for the new user
                return redirect()->route('barangay_captain.create_barangay_info_form');
            } else {
                return back()->withErrors(['email' => 'Your account is inactive or you do not have access.']);
            }
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }                
            
    public function showDashboard()
    {
        $user = Auth::guard('barangay_captain')->user();
    
        if ($user === null) {
            return redirect()->route('barangay_captain.login')->with('error', 'Please login to access the dashboard.');
        }
    
        $barangayDetails = $user->barangayDetails;
        $appearanceSettings = $user->appearanceSettings;
    
        return view('auth.barangay_captain.dashboard', compact('user', 'barangayDetails'));
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function showCreateBarangayInfo()
    {
        $user = Auth::guard('barangay_captain')->user();
        
        // Get the existing barangay if it exists
        $barangay = Barangay::where('barangay_captain_id', $user->id)->first();
    
        $geographicData = [
            'region' => $user->region,
            'province' => $user->province,
            'city' => $user->city_municipality,
            'barangay' => $user->barangay,
            'barangayDesc' => $this->getBarangayDesc($user->barangay)
        ];
    
        return view('auth.barangay_captain.create-barangay-info', compact('geographicData', 'barangay'));
    }

    private function getBarangayDesc($barangayCode)
    {
        $barangayJson = json_decode(file_get_contents(public_path('json/refbrgy.json')), true);
        foreach ($barangayJson['RECORDS'] as $barangay) {
            if ($barangay['brgyCode'] === $barangayCode) {
                return $barangay['brgyDesc'];
            }
        }
        return null;
    }

    public function createBarangayInfo(Request $request)
    {
        $request->validate([
            'barangay_name' => 'required|string|max:255',
            'barangay_email' => 'required|email|max:255',
            'barangay_office_address' => 'required|string|max:255',
            'barangay_complete_address_1' => 'required|string|max:255',
            'barangay_complete_address_2' => 'nullable|string|max:255',
            'barangay_description' => 'required|string',
            'barangay_contact_number' => 'required|string|max:20'
        ]);
    
        $user = Auth::guard('barangay_captain')->user();
    
        // Check if the barangay already exists for the user (barangay captain)
        $barangay = Barangay::where('barangay_captain_id', $user->id)->first();
    
        if ($barangay) {
            // Update existing barangay
            $barangay->update([
                'barangay_name' => $request->barangay_name,
                'barangay_email' => $request->barangay_email,
                'barangay_office_address' => $request->barangay_office_address,
                'barangay_complete_address_1' => $request->barangay_complete_address_1,
                'barangay_complete_address_2' => $request->barangay_complete_address_2,
                'barangay_description' => $request->barangay_description,
                'barangay_contact_number' => $request->barangay_contact_number,
            ]);
        } else {
            // Create new barangay if it doesn't exist
            $barangay = Barangay::create([
                'barangay_captain_id' => $user->id,
                'barangay_name' => $request->barangay_name,
                'barangay_email' => $request->barangay_email,
                'barangay_office_address' => $request->barangay_office_address,
                'barangay_complete_address_1' => $request->barangay_complete_address_1,
                'barangay_complete_address_2' => $request->barangay_complete_address_2,
                'barangay_description' => $request->barangay_description,
                'barangay_contact_number' => $request->barangay_contact_number,
                'region' => $user->region,
                'province' => $user->province,
                'city' => $user->city_municipality,
                'barangay' => $user->barangay,
            ]);
    
            // Update the active role with the new barangay ID
            $user->activeRole()->update(['barangay_id' => $barangay->id]);
        }
    
        // Check if the request is AJAX
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
    
        // Normal redirect if not AJAX (this shouldn't trigger for AJAX requests)
        return redirect()->route('barangay_captain.appearance_settings')->with('success', 'Barangay created successfully!');
    }         
    
    public function showAppearanceSettings()
    {
        $user = Auth::guard('barangay_captain')->user();
        $appearanceSettings = $user->appearanceSettings ?? new AppearanceSetting();
        return view('auth.barangay_captain.appearance-settings', compact('appearanceSettings'));
    }

    public function saveAppearanceSettings(Request $request)
    {
        $request->validate([
            'theme' => 'nullable|string',
            'theme_color' => 'required|string',
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
            'text_color' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $themes = $this->getThemes();
    
        if ($request->theme && isset($themes[$request->theme])) {
            $selectedTheme = $themes[$request->theme];
            $themeColor = $selectedTheme['theme_color'];
            $primaryColor = $selectedTheme['primary_color'];
            $secondaryColor = $selectedTheme['secondary_color'];
            $textColor = $selectedTheme['text_color'];
        } else {
            $themeColor = $this->convertToHex($request->theme_color);
            $primaryColor = $this->convertToHex($request->primary_color);
            $secondaryColor = $this->convertToHex($request->secondary_color);
            $textColor = $this->convertToHex($request->text_color);
        }
    
        $user = Auth::guard('barangay_captain')->user();
        $appearanceSettings = $user->appearanceSettings ?? new AppearanceSetting();
        $appearanceSettings->barangay_captain_id = $user->id;
        $appearanceSettings->theme_color = $themeColor;
        $appearanceSettings->primary_color = $primaryColor;
        $appearanceSettings->secondary_color = $secondaryColor;
        $appearanceSettings->text_color = $textColor;
    
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $appearanceSettings->logo_path = $logoPath;
        }                          
    
        $appearanceSettings->save();
    
        return redirect()->route('barangay_captain.features_settings')->with('success', 'Appearance settings saved successfully!');
    }    
    
    private function getThemes()
    {
        return [
            'default' => [
                'theme_color' => '#FAEED8',
                'primary_color' => '#503C2F',
                'secondary_color' => '#FAFAFA',
                'text_color' => '#000000',
            ],
            'dark' => [
                'theme_color' => '#2E2E2E',
                'primary_color' => '#1A1A1A',
                'secondary_color' => '#FAFAFA',
                'text_color' => '#FFFFFF',
            ],
            'blue' => [
                'theme_color' => '#E3F2FD',
                'primary_color' => '#2196F3',
                'secondary_color' => '#BBDEFB',
                'text_color' => '#0D47A1',
            ],
            'green' => [
                'theme_color' => '#E8F5E9',
                'primary_color' => '#4CAF50',
                'secondary_color' => '#C8E6C9',
                'text_color' => '#1B5E20',
            ],
        ];
    }    
    
    private function convertToHex($color)
    {
        if (strpos($color, '#') === 0) {
            return $color;
        }
    
        $rgb = sscanf($color, "rgb(%d, %d, %d)");
        if ($rgb) {
            return sprintf("#%02x%02x%02x", $rgb[0], $rgb[1], $rgb[2]);
        }
    
        $hsl = sscanf($color, "hsl(%d, %d%%, %d%%)");
        if ($hsl) {
            return $this->hslToHex($hsl[0], $hsl[1], $hsl[2]);
        }
    
        return $color; // fallback if conversion fails
    }
    
    private function hslToHex($h, $s, $l)
    {
        $h /= 360;
        $s /= 100;
        $l /= 100;
    
        $r = $l;
        $g = $l;
        $b = $l;
        $v = ($l <= 0.5) ? ($l * (1.0 + $s)) : ($l + $s - $l * $s);
        if ($v > 0) {
            $m = $l + $l - $v;
            $sv = ($v - $m) / $v;
            $h *= 6.0;
            $six = floor($h);
            $fract = $h - $six;
            $vsf = $v * $sv * $fract;
            $mid1 = $m + $vsf;
            $mid2 = $v - $vsf;
            switch ($six) {
                case 0:
                    $r = $v;
                    $g = $mid1;
                    $b = $m;
                    break;
                case 1:
                    $r = $mid2;
                    $g = $v;
                    $b = $m;
                    break;
                case 2:
                    $r = $m;
                    $g = $v;
                    $b = $mid1;
                    break;
                case 3:
                    $r = $m;
                    $g = $mid2;
                    $b = $v;
                    break;
                case 4:
                    $r = $mid1;
                    $g = $m;
                    $b = $v;
                    break;
                case 5:
                    $r = $v;
                    $g = $m;
                    $b = $mid2;
                    break;
            }
        }
    
        return sprintf("#%02x%02x%02x", round($r * 255.0), round($g * 255.0), round($b * 255.0));
    }    

    public function showFeaturesSettings()
    {
        // Get the current Barangay Captain
        $barangayCaptain = Auth::guard('barangay_captain')->user();

        if (!$barangayCaptain) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Get the barangay_id associated with the captain
        $barangayId = $barangayCaptain->barangay_id;

        // Fetch the selected features for the current barangay
        $selectedFeatures = $barangayCaptain->features()->pluck('features.id')->toArray();

        // Get all available features
        $features = Feature::all();

        return view('auth.barangay_captain.features-settings', compact('features', 'selectedFeatures'));
    }

    // Save Features Settings
    public function saveFeaturesSettings(Request $request)
    {
        // Get the authenticated Barangay Captain
        $barangayCaptain = Auth::guard('barangay_captain')->user();
        
        // Fetch the barangay that the Barangay Captain manages (using the barangayDetails relationship)
        $barangay = $barangayCaptain->barangayDetails;
    
        // If no barangay is found, return an error
        if (!$barangay) {
            return redirect()->back()->with('error', 'No Barangay found for this Barangay Captain.');
        }
    
        // Validate the incoming request
        $request->validate([
            'features' => 'array', // Ensure an array of features is submitted
            'features.*' => 'boolean', // Each feature must have a boolean value
        ]);
    
        // Prepare the data for syncing features
        $featureData = [];
        if ($request->has('features')) {
            foreach ($request->features as $featureId => $isEnabled) {
                $featureData[$featureId] = [
                    'is_enabled' => (bool) $isEnabled,
                ];
            }
        }
    
        // Sync features for the specific barangay (use the Barangay model's features() relationship)
        $barangay->features()->sync($featureData); // Sync the features for this barangay
    
        // Redirect back with a success message
        return redirect()->route('bc-dashboard')->with('success', 'Features updated successfully!');
    }           
    
    public function showBcDashboard()
    {
        $user = Auth::guard('barangay_captain')->user();
    
        if ($user === null) {
            return redirect()->route('barangay_captain.login')->with('error', 'Please login to access the dashboard.');
        }
    
        $barangayDetails = $user->barangayDetails; // Assuming this is from the barangays table
        $appearanceSettings = $user->appearanceSettings;
    
        // Load JSON files using the correct path
        $provinceJson = json_decode(file_get_contents(public_path('json/refprovince.json')), true);
        $citymunJson = json_decode(file_get_contents(public_path('json/refcitymun.json')), true);
    
        if (!$provinceJson || !$citymunJson) {
            dd('JSON files not found or error in decoding');
        }
    
        // Initialize descriptions with default values
        $provinceDesc = 'Unknown Province';
        $citymunDesc = 'Unknown City/Municipality';
    
        if ($barangayDetails) {
            $provinceCode = (string) $barangayDetails->province;
            $citymunCode = (string) $barangayDetails->city;
    
            // Find province description
            foreach ($provinceJson['RECORDS'] as $province) {
                if ($province['provCode'] === $provinceCode) {
                    $provinceDesc = $province['provDesc'];
                    break;
                }
            }
    
            // Find city/municipality description
            foreach ($citymunJson['RECORDS'] as $city) {
                if ($city['citymunCode'] === $citymunCode) {
                    $citymunDesc = $city['citymunDesc'];
                    break;
                }
            }
        }
    
        // Total members count
        $totalMembers = BarangayOfficial::where('barangay_id', $barangayDetails->id)->count()
                        + Staff::where('barangay_id', $barangayDetails->id)->count()
                        + Resident::where('barangay_id', $barangayDetails->id)->count();
    
        return view('barangay_captain.bc-dashboard', compact('user', 'appearanceSettings', 'barangayDetails', 'provinceDesc', 'citymunDesc', 'totalMembers'));
    }

    public function showRequests()
    {
        $user = Auth::guard('barangay_captain')->user();
        $barangayId = $user->barangayDetails->id;
    
        // Fetch all pending requests for this barangay
        $requests = SignupRequest::where('barangay_id', $barangayId)
                    ->where('status', 'pending')
                    ->get();
    
        // Fetch appearance settings
        $appearanceSettings = $user->appearanceSettings;
    
        return view('barangay_captain.bc-requests', compact('requests', 'appearanceSettings'));
    }
    
    
    public function approveRequest($id)
    {
        $request = SignupRequest::findOrFail($id);
        $userModel = $this->getUserModel($request->user_type);
    
        $existingUser = $userModel::where('email', $request->email)
            ->orWhere('contact_no', $request->contact_no)
            ->first();
    
        if ($existingUser) {
            return redirect()->route('bc-requests')->with('error', 'A user with the same email or contact number already exists.');
        }
    
        $hashedPassword = $request->password;
    
        $data = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'barangay_id' => $request->barangay_id,
            'password' => $hashedPassword,
            'valid_id' => $request->valid_id,
            'position' => $request->position,
        ];
    
        if ($request->user_type === 'barangay_resident') {
            $data['house_number_building_name'] = $request->house_number_building_name;
            $data['street_purok_sitio'] = $request->street_purok_sitio;
            $data['is_renter'] = $request->is_renter;
            $data['is_employed'] = $request->is_employed;
        }
    
        $user = $userModel::create($data);
    
        $request->update([
            'user_id' => $user->id,
            'status' => 'accepted',
        ]);
    
        return redirect()->route('bc-requests')->with('success', 'Request accepted successfully.');
    }   
        
    public function denyRequest($id)
    {
        $request = SignupRequest::findOrFail($id);
    
        if ($request->valid_id && Storage::disk('public')->exists($request->valid_id)) {
            Storage::disk('public')->delete($request->valid_id);
        }
    
        $request->update(['status' => 'denied']);
    
        return redirect()->route('bc-requests')->with('success', 'Request denied and valid ID deleted successfully.');
    }   
    
    private function getUserModel($userType)
    {
        switch ($userType) {
            case 'barangay_official':
                return \App\Models\BarangayOfficial::class;
            case 'barangay_staff':
                return \App\Models\Staff::class;
            case 'barangay_resident':
                return \App\Models\Resident::class;
            default:
                throw new \Exception("Unknown user type: $userType");
        }
    }
    
    public function showRequestHistory()
    {
        $user = Auth::guard('barangay_captain')->user();
        $barangayId = $user->barangayDetails->id;
    
        // Fetch all requests for this barangay
        $requests = SignupRequest::where('barangay_id', $barangayId)
                                 ->whereIn('status', ['accepted', 'denied'])
                                 ->orderBy('updated_at', 'desc')
                                 ->get();
    
        // Fetch appearance settings
        $appearanceSettings = $user->appearanceSettings;
    
        return view('barangay_captain.bc-request-history', compact('requests', 'appearanceSettings'));
    }

    public function showSettings()
    {
        $user = Auth::guard('barangay_captain')->user();
        $appearanceSettings = $user->appearanceSettings;

        return view('barangay_captain.settings.bc-settings', compact('appearanceSettings'));
    }

    public function showCustomizeBarangay()
    {
        $user = Auth::guard('barangay_captain')->user();
    
        if ($user === null) {
            return redirect()->route('login')->with('error', 'Please login to access the dashboard.');
        }
    
        // Fetch the current barangay info (fetch through the relationship)
        $barangay = $user->barangayDetails;
    
        if (!$barangay) {
            return redirect()->back()->with('error', 'No Barangay found for this Barangay Captain.');
        }
    
        // Fetch appearance settings
        $appearanceSettings = $user->appearanceSettings ?? new AppearanceSetting();
    
        // Fetch selected features for the barangay
        $selectedFeatures = $barangay->features()->pluck('features.id')->toArray();
    
        // Fetch all available features
        $features = Feature::all();
    
        // Pass all the necessary data to the customize view
        return view('barangay_captain.customize.bc-customize', compact('user', 'barangay', 'appearanceSettings', 'features', 'selectedFeatures'));
    }
}    