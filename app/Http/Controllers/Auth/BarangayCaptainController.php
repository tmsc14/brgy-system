<?php

namespace App\Http\Controllers\Auth;

use App\Models\AccessCode;
use Illuminate\Http\Request;
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
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required',
            'email' => 'required|email',
            'contact_no' => 'required',
            'bric' => 'required',
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
        $request->validate([
            'password' => 'required|confirmed',
            'access_code' => 'required|exists:access_codes,code',
        ]);

        if (BarangayCaptain::where('email', session('email'))->exists()) {
            return redirect()->back()->with('error', 'The email has already been taken.')->withInput();
        }

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

        session()->flush();

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
        return view('auth.barangay_captain.create-barangay-info');
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

        // Save the data to the session
        session([
            'barangay_name' => $request->barangay_name,
            'barangay_email' => $request->barangay_email,
            'barangay_office_address' => $request->barangay_office_address,
            'barangay_complete_address_1' => $request->barangay_complete_address_1,
            'barangay_complete_address_2' => $request->barangay_complete_address_2,
            'barangay_description' => $request->barangay_description,
            'barangay_contact_number' => $request->barangay_contact_number,
        ]);

        return redirect()->route('barangay_captain.create_barangay_appearances');
    }
}
