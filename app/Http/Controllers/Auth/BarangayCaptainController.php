<?php

namespace App\Http\Controllers\Auth;

use App\Models\AccessCode;
use Illuminate\Http\Request;
use App\Models\BarangayCaptain;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

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
            'date_of_birth' => 'required|date',
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
    
        return redirect()->route('home')->with('success', 'Registration successful');
    }         
}
