<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\BarangayOfficial;
use App\Models\Staff;
use App\Models\Resident;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BarangayRoleController extends Controller
{
    public function showSelectRole()
    {
        return view('auth.barangay_roles.select_role');
    }

    public function selectRole(Request $request)
    {
        $request->session()->put('role', $request->input('role'));
        return redirect()->route('barangay_roles.showFindBarangay');
    }

    public function showFindBarangay()
    {
        // Fetch distinct regions from geographic_data table
        $regions = DB::table('geographic_data')->distinct()->pluck('regDesc', 'regCode');
        return view('auth.barangay_roles.find_barangay', compact('regions'));
    }

    public function findBarangay(Request $request)
    {
        // Find the created barangay by Barangay Captains
        $barangay = DB::table('barangays')
            ->where('region', $request->input('region'))
            ->where('province', $request->input('province'))
            ->where('city', $request->input('city'))
            ->where('name', $request->input('barangay'))
            ->first();

        if ($barangay) {
            $request->session()->put('barangay_id', $barangay->id);
            return redirect()->route('barangay_roles.showUserDetails');
        } else {
            return back()->withErrors(['barangay' => 'Barangay not found']);
        }
    }

    public function showUserDetails()
    {
        return view('auth.barangay_roles.user_details');
    }

    public function userDetails(Request $request)
    {
        $request->session()->put('user_details', $request->only([
            'first_name', 'middle_name', 'last_name', 'dob', 'gender', 'email', 'contact_no', 'bric_no'
        ]));
        return redirect()->route('barangay_roles.showAccountDetails');
    }

    public function showAccountDetails()
    {
        $role = session('role');
        return view('auth.barangay_roles.account_details', compact('role'));
    }

    public function accountDetails(Request $request)
    {
        $role = $request->session()->get('role');
        $barangay_id = $request->session()->get('barangay_id');
        $user_details = $request->session()->get('user_details');

        $data = [
            'first_name' => $user_details['first_name'],
            'middle_name' => $user_details['middle_name'],
            'last_name' => $user_details['last_name'],
            'dob' => $user_details['dob'],
            'gender' => $user_details['gender'],
            'email' => $user_details['email'],
            'contact_no' => $user_details['contact_no'],
            'bric_no' => $user_details['bric_no'],
            'barangay_id' => $barangay_id,
            'password' => Hash::make($request->input('password')),
        ];

        if ($request->hasFile('valid_id')) {
            $data['valid_id'] = $request->file('valid_id')->store('valid_ids');
        }

        switch ($role) {
            case 'barangay_official':
                $data['position'] = $request->input('position');
                BarangayOfficial::create($data);
                break;
            case 'staff':
                $data['role'] = $request->input('role');
                Staff::create($data);
                break;
            case 'resident':
                Resident::create($data);
                break;
        }

        return redirect()->route('login')->with('success', 'Registration completed successfully.');
    }
}
