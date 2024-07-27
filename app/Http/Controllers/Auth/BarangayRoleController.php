<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\BarangayOfficial;
use App\Models\Staff;
use App\Models\Resident;
use Illuminate\Support\Facades\Log;

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
        // Fetch distinct regions from the created barangays
        $regions = DB::table('barangays')->select('region')->distinct()->get()->pluck('region');

        // Load region descriptions from JSON
        $regionJson = json_decode(file_get_contents(public_path('json/refregion.json')), true);
        $regionMap = [];
        foreach ($regionJson['RECORDS'] as $region) {
            $regionMap[$region['regCode']] = $region['regDesc'];
        }

        // Map region codes to descriptions
        $regions = $regions->map(function ($region) use ($regionMap) {
            return ['code' => $region, 'desc' => $regionMap[$region] ?? $region];
        });

        return view('auth.barangay_roles.find_barangay', compact('regions'));
    }

    public function getProvinces(Request $request)
    {
        $provinces = DB::table('barangays')
            ->where('region', $request->query('region'))
            ->select('province')
            ->distinct()
            ->get();

        // Load province descriptions from JSON
        $provinceJson = json_decode(file_get_contents(public_path('json/refprovince.json')), true);
        $provinceMap = [];
        foreach ($provinceJson['RECORDS'] as $province) {
            $provinceMap[$province['provCode']] = $province['provDesc'];
        }

        // Map province codes to descriptions
        $provinces = $provinces->map(function ($province) use ($provinceMap) {
            return ['code' => $province->province, 'desc' => $provinceMap[$province->province] ?? $province->province];
        });

        return response()->json($provinces);
    }

    public function getCities(Request $request)
    {
        $cities = DB::table('barangays')
            ->where('province', $request->query('province'))
            ->select('city')
            ->distinct()
            ->get();

        // Load city descriptions from JSON
        $cityJson = json_decode(file_get_contents(public_path('json/refcitymun.json')), true);
        $cityMap = [];
        foreach ($cityJson['RECORDS'] as $city) {
            $cityMap[$city['citymunCode']] = $city['citymunDesc'];
        }

        // Map city codes to descriptions
        $cities = $cities->map(function ($city) use ($cityMap) {
            return ['code' => $city->city, 'desc' => $cityMap[$city->city] ?? $city->city];
        });

        return response()->json($cities);
    }

    public function getBarangays(Request $request)
    {
        $barangays = DB::table('barangays')
            ->where('city', $request->query('city'))
            ->select('barangay')
            ->distinct()
            ->get();

        // Load barangay descriptions from JSON
        $barangayJson = json_decode(file_get_contents(public_path('json/refbrgy.json')), true);
        $barangayMap = [];
        foreach ($barangayJson['RECORDS'] as $barangay) {
            $barangayMap[$barangay['brgyCode']] = $barangay['brgyDesc'];
        }

        // Map barangay codes to descriptions
        $barangays = $barangays->map(function ($barangay) use ($barangayMap) {
            return ['code' => $barangay->barangay, 'desc' => $barangayMap[$barangay->barangay] ?? $barangay->barangay];
        });

        return response()->json($barangays);
    }

    public function findBarangay(Request $request)
    {
        // Find the created barangay by Barangay Captains
        $barangay = DB::table('barangays')
            ->where('region', $request->input('region'))
            ->where('province', $request->input('province'))
            ->where('city', $request->input('city'))
            ->where('barangay', $request->input('barangay'))
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

        return redirect()->route('barangay_roles.showLogin')->with('success', 'Registration completed successfully.');
    }

    public function showUnifiedLogin()
    {
        return view('auth.barangay_roles.unified_login');
    }

    public function unifiedLogin(Request $request)
    {
        Log::info('Login attempt started');
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $role = $request->input('role');

        Log::info('Login role: ' . $role);

        switch ($role) {
            case 'barangay_official':
                if (Auth::guard('barangay_official')->attempt($credentials)) {
                    Log::info('Barangay Official login successful');
                    $request->session()->regenerate();
                    return redirect()->route('barangay_official.dashboard');
                }
                break;
            case 'staff':
                if (Auth::guard('staff')->attempt($credentials)) {
                    Log::info('Staff login successful');
                    $request->session()->regenerate();
                    return redirect()->route('staff.dashboard');
                }
                break;
            case 'resident':
                if (Auth::guard('resident')->attempt($credentials)) {
                    Log::info('Resident login successful');
                    $request->session()->regenerate();
                    return redirect()->route('resident.dashboard');
                }
                break;
        }

        Log::warning('Login failed for role: ' . $role);
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
