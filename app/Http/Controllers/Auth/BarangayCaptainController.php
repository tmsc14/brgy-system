<?php

namespace App\Http\Controllers\Auth;

use App\Models\AccessCode;
use App\Models\AppearanceSetting;
use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\BarangayCaptain;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
            'bric' => [
                'required',
                'alpha_num',
                'min:6',
                'max:20',
                Rule::unique('barangay_captains', 'bric'),
                Rule::unique('barangay_officials', 'bric_no'),
                Rule::unique('barangay_staff', 'bric_no'),
                Rule::unique('barangay_residents', 'bric_no'),
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
            'bric' => $request->bric,
        ]);
    
        return redirect()->route('barangay_captain.register.step3');
    }    
    
    public function showStep3()
    {
        return view('auth.barangay_captain.bc-signup-step3');
    }

    public function postStep3(Request $request)
    {
        // Validate the request
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                'min:8', // Minimum length
                'regex:/[A-Z]/', // Must contain at least one uppercase letter
                'regex:/[a-z]/', // Must contain at least one lowercase letter
                'regex:/[0-9]/', // Must contain at least one number
                'regex:/[@$!%*?&#]/', // Must contain at least one special character
            ],
            'access_code' => 'required|exists:access_codes,code',
        ], [
            'password.required' => 'Password is required',
            'password.confirmed' => 'Passwords do not match',
            'password.min' => 'Password must be at least 8 characters',
            'password.regex' => 'Password must include uppercase, lowercase, number, and special character',
            'access_code.required' => 'Access code is required',
            'access_code.exists' => 'Invalid access code',
        ]);
    
        // Create the Barangay Captain
        BarangayCaptain::create([
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
            'bric' => session('bric'),
            'password' => Hash::make($request->password),
        ]);
    
        // Clear the session data
        session()->flush();
    
        // Redirect to the login page with a success message
        return redirect()->route('barangay_captain.login')->with('success', 'Registration successful! Please log in.');
    }    
    
    public function showLogin()
    {
        return view('auth.barangay_captain.bc-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('barangay_captain')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('barangay_captain.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showDashboard()
    {
        $user = Auth::guard('barangay_captain')->user();
    
        if ($user === null) {
            return redirect()->route('barangay_captain.login')->with('error', 'Please login to access the dashboard.');
        }
    
        $barangayDetails = $user->barangayDetails;
    
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
        $geographicData = [
            'region' => $user->region,
            'province' => $user->province,
            'city' => $user->city_municipality,
            'barangay' => $user->barangay,
            'barangayDesc' => $this->getBarangayDesc($user->barangay)
        ];

        return view('auth.barangay_captain.create-barangay-info', compact('geographicData'));
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

        Barangay::create([
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
            'barangay' => $user->barangay
        ]);

        return redirect()->route('barangay_captain.dashboard')->with('success', 'Barangay created successfully!');
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
    
        return redirect()->route('barangay_captain.dashboard')->with('success', 'Appearance settings saved successfully!');
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
        return view('auth.barangay_captain.features-settings');
    }

    public function saveFeaturesSettings(Request $request)
    {
        $request->validate([
            'feature_1' => 'required|boolean',
            // Add other features settings fields validation
        ]);

        // Save features settings logic here

        return redirect()->route('barangay_captain.dashboard')->with('success', 'Features settings saved successfully!');
    }

    public function showBcDashboard()
    {
        $user = Auth::guard('barangay_captain')->user();
    
        if ($user === null) {
            return redirect()->route('barangay_captain.login')->with('error', 'Please login to access the dashboard.');
        }
    
        $appearanceSettings = $user->appearanceSettings;
        $barangayDetails = $user->barangayDetails;
    
        return view('barangay_captain.bc-dashboard', compact('user', 'appearanceSettings', 'barangayDetails'));
    }
}
