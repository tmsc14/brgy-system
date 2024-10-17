<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function showHome(Request $request)
    {
        $user = Auth::user();
        $barangay = $user->barangay;

        if (!Auth::user()->roles()->where('name', 'Captain')->exists()
            && !$barangay->is_setup_complete)
        {
            return redirect()->route('home')->with('error', 'Your barangay has not finished setting up.');
        }
        if (Auth::user()->roles()->where('name', 'Captain')->exists()
            && !$barangay->is_setup_complete)
        {
            return redirect()->route('barangay.setup');
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
