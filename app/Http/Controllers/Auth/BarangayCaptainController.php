<?php

namespace App\Http\Controllers\Auth;

use App\Models\AccessCode;
use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\BarangayCaptain;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
            'first_name' => 'required|alpha|min:2|max:50',
            'middle_name' => 'nullable|alpha|min:2|max:50',
            'last_name' => 'required|alpha|min:2|max:50',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email|unique:barangay_captains,email',
            'contact_no' => 'required|digits_between:10,15',
            'bric' => 'required|alpha_num|min:6|max:20',
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
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
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
    
        $barangay = $user->barangay;
    
        // Debugging the type and value of $barangay
        \Log::info('Barangay type: ' . gettype($barangay));
        \Log::info('Barangay value: ' . json_encode($barangay));
    
        return view('auth.barangay_captain.dashboard', compact('user', 'barangay'));
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
        $barangayDesc = $this->getBarangayDesc($user->barangay);

        return view('auth.barangay_captain.create-barangay-info', compact('barangayDesc'));
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
            'barangay_contact_number' => 'required|string|max:20',
        ]);

        Barangay::create([
            'barangay_captain_id' => Auth::guard('barangay_captain')->id(),
            'barangay_name' => $request->barangay_name,
            'barangay_email' => $request->barangay_email,
            'barangay_office_address' => $request->barangay_office_address,
            'barangay_complete_address_1' => $request->barangay_complete_address_1,
            'barangay_complete_address_2' => $request->barangay_complete_address_2,
            'barangay_description' => $request->barangay_description,
            'barangay_contact_number' => $request->barangay_contact_number,
        ]);

        return redirect()->route('barangay_captain.dashboard')->with('success', 'Barangay created successfully!');
    }
    
    public function showAppearanceSettings()
    {
        return view('auth.barangay_captain.appearance-settings');
    }

    public function saveAppearanceSettings(Request $request)
    {
        $request->validate([
            'theme_color' => 'required|string',
            // Add other appearance settings fields validation
        ]);

        // Save appearance settings logic here

        return redirect()->route('barangay_captain.dashboard')->with('success', 'Appearance settings saved successfully!');
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
        $user = auth()->guard('barangay_captain')->user()->load('barangay');

        // Add debug logging to see what is being returned
        \Log::info('User data:', ['user' => $user]);

        return view('barangay_captain.bc-dashboard', compact('user'));
    }
}
