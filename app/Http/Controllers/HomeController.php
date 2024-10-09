<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function showStaffHome(Request $request)
    {
        $user = Auth::user();
        $barangay = $user->barangay;

        if (!$barangay->is_setup_complete)
        {
            return redirect()->route('barangay_captain.create_barangay_info_form');
        }
        else
        {
            return view('dashboard');
        }
    }

    public function showResidentHome(Request $request)
    {
        $user = Auth::user();
        $barangay = $user->barangay;

        if (!$barangay->is_setup_complete)
        {
            return redirect()->route('home')->with('error', 'Your barangay has not finished setting up.');
        }
        else
        {
            return view('dashboard');
        }
    }
}
