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
use App\Models\FeaturePermission;
use App\Models\BarangayFeatureSetting;
use Illuminate\Support\Facades\DB;
use App\Traits\AppearanceSettingsTrait;

class BarangayCaptainController extends Controller
{
    use AppearanceSettingsTrait;

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
            'user_type' => \App\Models\BarangayCaptain::class, // Add user_type here (polymorphic)
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
    
        // Check if the new captain already has a role in the roles table
        $newCaptainRole = $newCaptain->roles()->where('role_type', 'barangay_captain')->first();
    
        if ($newCaptainRole) {
            // If a role exists for the new captain, update it
            $newCaptainRole->update([
                'active' => true,
                'barangay_id' => $currentUser->barangayDetails->id,
            ]);
        } else {
            // If no role exists, create a new role
            $newCaptain->roles()->create([
                'user_type' => \App\Models\BarangayCaptain::class,
                'barangay_id' => $currentUser->barangayDetails->id,
                'role_type' => 'barangay_captain',
                'active' => true,
            ]);
        }
    
        // Update the barangay's captain_id to the new captain
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
            $user->activeRole()->update(['barangay_id' => $barangay->id]);
        }
    
        // Check if the request is coming from the bc-customize page
        if ($request->input('from_customization') === 'true') {
            return redirect()->route('barangay_captain.customize_barangay')->with('success', 'Barangay information updated successfully!');
        }
    
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
    
        // Redirect based on the source of the request
        if ($request->input('from_customization') === 'true') {
            return redirect()->route('barangay_captain.customize_barangay')->with('success', 'Appearance settings updated successfully!');
        }
    
        return redirect()->route('barangay_captain.features_settings')->with('success', 'Appearance settings saved successfully!');
    }           

    public function showFeaturesSettings()
    {
        $barangayCaptain = Auth::guard('barangay_captain')->user();
    
        if (!$barangayCaptain) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
    
        $barangay = $barangayCaptain->barangayDetails;
    
        if (!$barangay) {
            return redirect()->back()->with('error', 'No Barangay found for this Barangay Captain.');
        }
    
        // Fetch enabled features for the barangay
        $enabledFeatures = $barangay->features()->pluck('features.id')->toArray();
    
        // Fetch all features
        $features = Feature::all();
    
        // Fetch permissions for staff and officials
        $permissions = FeaturePermission::whereIn('role', ['staff', 'official'])
            ->where('permissible_type', $barangayCaptain->getMorphClass())
            ->where('permissible_id', $barangayCaptain->id)
            ->get();
    
        // Get the ID for the 'statistics' feature category
        $statisticsFeature = Feature::where('name', 'statistics')->first();
        $statisticsFeatureId = $statisticsFeature ? $statisticsFeature->id : null;
    
        return view('auth.barangay_captain.features-settings', compact(
            'features', 
            'enabledFeatures', 
            'permissions', 
            'statisticsFeatureId' // Pass this variable to the view
        ));
    }
          

    public function saveFeaturesSettings(Request $request)
    {
        $barangayCaptain = Auth::guard('barangay_captain')->user();
        $barangay = $barangayCaptain->barangayDetails;
    
        if (!$barangay) {
            return redirect()->back()->with('error', 'No Barangay found for this Barangay Captain.');
        }
    
        // Handle feature enabling/disabling
        $featuresToUpdate = array_keys($request->input('features.statistics', []));
        $allStatisticsFeatures = Feature::where('category', 'statistics')->pluck('id')->toArray();
    
        // Disable all statistics features by default
        BarangayFeatureSetting::where('barangay_id', $barangay->id)
            ->whereIn('feature_id', $allStatisticsFeatures)
            ->update(['is_enabled' => false]);
    
        // Enable selected features
        if (!empty($featuresToUpdate)) {
            foreach ($featuresToUpdate as $featureId) {
                BarangayFeatureSetting::updateOrCreate(
                    ['barangay_id' => $barangay->id, 'feature_id' => $featureId],
                    ['is_enabled' => true]
                );
            }
        }
    
        // Handle staff permissions
        $canViewStaff = $request->input('permissions.staff.statistics.view') ? true : false;
        $canEditStaff = $request->input('permissions.staff.statistics.edit') ? true : false;
    
        foreach ($allStatisticsFeatures as $featureId) {
            FeaturePermission::updateOrCreate(
                [
                    'permissible_type' => $barangayCaptain->getMorphClass(),
                    'permissible_id' => $barangayCaptain->id,
                    'feature_id' => $featureId,
                    'role' => 'staff',
                ],
                [
                    'can_view' => $canViewStaff,
                    'can_edit' => $canEditStaff,
                ]
            );
        }
    
        // Handle officials permissions
        $canViewOfficials = $request->input('permissions.officials.statistics.view') ? true : false;
        $canEditOfficials = $request->input('permissions.officials.statistics.edit') ? true : false;
    
        foreach ($allStatisticsFeatures as $featureId) {
            FeaturePermission::updateOrCreate(
                [
                    'permissible_type' => $barangayCaptain->getMorphClass(),
                    'permissible_id' => $barangayCaptain->id,
                    'feature_id' => $featureId,
                    'role' => 'official',
                ],
                [
                    'can_view' => $canViewOfficials,
                    'can_edit' => $canEditOfficials,
                ]
            );
        }
    
        // Redirect based on the source of the request
        if ($request->input('from_customization') === 'true') {
            return redirect()->route('barangay_captain.customize_barangay')->with('success', 'Features updated successfully!');
        }
    
        return redirect()->route('bc-dashboard')->with('success', 'Features updated successfully!');
    }                                                                                                                              
    
    public function showBcDashboard()
    {
        $user = Auth::guard('barangay_captain')->user();
    
        if ($user === null) {
            return redirect()->route('barangay_captain.login')->with('error', 'Please login to access the dashboard.');
        }
    
        $barangayDetails = $user->barangayDetails;
        $appearanceSettings = $user->appearanceSettings;
    
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
        // Log the request approval process
        Log::info('Approve request triggered for request ID: ' . $id);
        
        // Retrieve the signup request by ID
        $request = SignupRequest::findOrFail($id);
        
        // Get the user model based on the user type (barangay_official, barangay_staff)
        $userModel = $this->getUserModel($request->user_type);
        
        // Check if a user with the same email or contact number already exists
        $existingUser = $userModel::where('email', $request->email)
            ->orWhere('contact_no', $request->contact_no)
            ->first();
        
        if ($existingUser) {
            // If user exists, check if the request status is still pending
            if ($request->status === 'pending') {
                Log::info('User exists, but request is pending. Proceeding to update role and request status.');
                
                // Update the role and set the status to accepted
                $this->assignRole($existingUser, $request->barangay_id, $request->user_type); // Pass the model, not just the ID
                
                $request->update([
                    'status' => 'accepted',
                ]);
                
                return redirect()->route('bc-requests')->with('success', 'Request accepted successfully.');
            } else {
                Log::warning('User already exists and the request is already processed.');
                return redirect()->route('bc-requests')->with('error', 'This request has already been processed.');
            }
        }
    
        // Hash the password
        $hashedPassword = $request->password; // Ensure password is hashed if necessary
        
        // Prepare the data to be inserted into the user table (BarangayOfficial, Staff, etc.)
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
    
        // Log the data being inserted
        Log::info('Data to be inserted: ', $data);
        
        // Create the user in the respective table
        $user = $userModel::create($data);
        
        // Log user creation
        Log::info('User created with ID: ' . $user->id);
        
        // Assign a role to the user
        $this->assignRole($user, $request->barangay_id, $request->user_type); // Pass the model, not just the ID
        
        // Update the signup request with the newly created user ID and change the status to accepted
        $request->update([
            'user_id' => $user->id,
            'status' => 'accepted',
        ]);
    
        // Log role creation
        Log::info('Request approved for user ID: ' . $user->id);
    
        // Redirect back to the requests page with a success message
        return redirect()->route('bc-requests')->with('success', 'Request accepted successfully.');
    }    
        
    private function assignRole($user, $barangayId, $userType)
    {
        // Use the polymorphic relationship
        Role::create([
            'user_id' => $user->id,        // Reference to the user's ID
            'user_type' => get_class($user),  // The class of the user (e.g., BarangayOfficial, Staff)
            'barangay_id' => $barangayId,
            'role_type' => $userType,  // This could be 'barangay_official' or 'barangay_staff'
            'active' => true,
        ]);
    
        Log::info('Role assigned to user ID: ' . $user->id . ' as ' . $userType);
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

    public function showCustomizeBarangay()
    {
        $user = Auth::guard('barangay_captain')->user();
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to access the dashboard.');
        }
    
        $barangay = $user->barangayDetails;
    
        if (!$barangay) {
            return redirect()->back()->with('error', 'No barangay found for this Barangay Captain.');
        }
    
        // Fetch appearance settings
        $appearanceSettings = $user->appearanceSettings ?? new AppearanceSetting();
    
        // Fetch all available statistics features
        $features = Feature::where('category', 'statistics')->get();
    
        // Fetch enabled features for the barangay
        $enabledFeatures = BarangayFeatureSetting::where('barangay_id', $barangay->id)
            ->where('is_enabled', true)
            ->pluck('feature_id')
            ->toArray();
    
        // Prepare feature data
        $enabledFeaturesByCategory = ['statistics' => []];
        foreach ($features as $feature) {
            if (in_array($feature->id, $enabledFeatures)) {
                $enabledFeaturesByCategory['statistics'][] = $feature->id;
            }
        }
    
        // Get the feature ID for statistics page
        $statisticsFeatureId = Feature::where('name', 'statistics')->first()->id ?? 1;
    
        // Fetch permissions for staff and officials
        $staffPermissions = FeaturePermission::where('role', 'staff')
            ->where('permissible_type', $user->getMorphClass())
            ->where('permissible_id', $user->id)
            ->get()
            ->keyBy('feature_id');
    
        $officialsPermissions = FeaturePermission::where('role', 'official')
            ->where('permissible_type', $user->getMorphClass())
            ->where('permissible_id', $user->id)
            ->get()
            ->keyBy('feature_id');
    
        return view('barangay_captain.customize.bc-customize', compact(
            'user',
            'barangay',
            'appearanceSettings',
            'features',
            'enabledFeaturesByCategory',
            'enabledFeatures',  // Make sure this variable is passed
            'staffPermissions',
            'officialsPermissions',
            'statisticsFeatureId'
        ));
    }                                                                     

    //statistics
    public function showCaptainStatistics()
    {
        $user = Auth::guard('barangay_captain')->user();
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to access the dashboard.');
        }
    
        // Fetch the barangay managed by the Barangay Captain
        $barangay = $user->barangayDetails;
    
        if (!$barangay) {
            return redirect()->back()->with('error', 'No barangay found for this Barangay Captain.');
        }
    
        // The rest of the logic can stay the same as in other roles.
        $appearanceSettings = $barangay->appearanceSettings;
    
        // Fetch enabled features for the barangay
        $enabledFeatures = DB::table('barangay_feature_settings')
            ->where('barangay_id', $barangay->id)
            ->where('is_enabled', true)
            ->pluck('feature_id')
            ->toArray();
    
        $features = Feature::whereIn('id', $enabledFeatures)->get();
    
        // Fetch number of residents
        $residentsCount = DB::table('barangay_residents')->where('barangay_id', $barangay->id)->count();
    
        // Fetch number of households by joining 'households' and 'barangay_residents' tables
        $householdsCount = DB::table('households')
            ->join('barangay_residents', 'households.resident_id', '=', 'barangay_residents.id')
            ->where('barangay_residents.barangay_id', $barangay->id)
            ->count();
    
        $totalResidentsCount = $residentsCount + $householdsCount;
    
                // Gender Demographics
                $genderDemographicsResidents = DB::table('barangay_residents')
                ->select(DB::raw('gender, COUNT(*) as count'))
                ->where('barangay_id', $barangay->id)
                ->groupBy('gender')
                ->get();
        
            $genderDemographicsHouseholds = DB::table('households')
                ->join('barangay_residents', 'households.resident_id', '=', 'barangay_residents.id')
                ->where('barangay_residents.barangay_id', $barangay->id)
                ->select(DB::raw('households.gender, COUNT(*) as count'))
                ->groupBy('households.gender')
                ->get();
        
            $genderDemographics = $genderDemographicsResidents->merge($genderDemographicsHouseholds)
                ->groupBy('gender')
                ->map(function ($group) {
                    return $group->sum('count');
                });
        
            // Age Demographics (Group by Age Ranges)
            $ageDemographicsResidents = DB::table('barangay_residents')
                ->select(DB::raw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age'))
                ->where('barangay_id', $barangay->id)
                ->get();
        
            $ageDemographicsHouseholds = DB::table('households')
                ->join('barangay_residents', 'households.resident_id', '=', 'barangay_residents.id')
                ->where('barangay_residents.barangay_id', $barangay->id)
                ->select(DB::raw('TIMESTAMPDIFF(YEAR, households.dob, CURDATE()) AS age'))
                ->get();
        
            $ageDemographics = $ageDemographicsResidents->merge($ageDemographicsHouseholds)
                ->groupBy(function ($person) {
                    $age = $person->age;
                    if ($age < 18) {
                        return 'children';
                    } elseif ($age >= 18 && $age < 60) {
                        return 'adults';
                    } else {
                        return 'senior_citizens';
                    }
                })->map(function ($group) {
                    return count($group);
                });
    
        return view('barangay_captain.statistics.bc-statistics', compact(
                    'barangay', 'features', 'totalResidentsCount', 'householdsCount', 'appearanceSettings', 'genderDemographics', 'ageDemographics'
        ));                
    }
    
    //admins page
    public function showAdmins()
    {
        $user = Auth::guard('barangay_captain')->user();
        
        $appearanceSettings = $user->appearanceSettings;
    
        // Fetch roles with user relation (barangay_official or barangay_staff)
        $admins = Role::where('barangay_id', $user->barangayDetails->id)
                      ->whereIn('role_type', ['barangay_official', 'barangay_staff']) // Only include officials and staff
                      ->with('user') // Load the user associated with the role
                      ->get();
    
        // Ensure we have valid users in the list
        $filteredAdmins = $admins->filter(function ($admin) {
            return $admin->user; // Only return roles where a valid user exists
        });
    
        return view('barangay_captain.admins.bc-admins', compact('filteredAdmins', 'appearanceSettings'));
    }                           
    
    public function toggleRoleStatus($roleId)
    {
        $role = Role::findOrFail($roleId);
        $role->active = !$role->active; // Toggle active/inactive
        $role->save();
    
        return redirect()->back()->with('success', 'Role status updated successfully!');
    }      
}    