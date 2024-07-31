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
use Illuminate\Validation\Rule;

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
        $regions = DB::table('barangays')->select('region')->distinct()->get()->pluck('region');

        $regionJson = json_decode(file_get_contents(public_path('json/refregion.json')), true);
        $regionMap = [];
        foreach ($regionJson['RECORDS'] as $region) {
            $regionMap[$region['regCode']] = $region['regDesc'];
        }

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

        $provinceJson = json_decode(file_get_contents(public_path('json/refprovince.json')), true);
        $provinceMap = [];
        foreach ($provinceJson['RECORDS'] as $province) {
            $provinceMap[$province['provCode']] = $province['provDesc'];
        }

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

        $cityJson = json_decode(file_get_contents(public_path('json/refcitymun.json')), true);
        $cityMap = [];
        foreach ($cityJson['RECORDS'] as $city) {
            $cityMap[$city['citymunCode']] = $city['citymunDesc'];
        }

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

        $barangayJson = json_decode(file_get_contents(public_path('json/refbrgy.json')), true);
        $barangayMap = [];
        foreach ($barangayJson['RECORDS'] as $barangay) {
            $barangayMap[$barangay['brgyCode']] = $barangay['brgyDesc'];
        }

        $barangays = $barangays->map(function ($barangay) use ($barangayMap) {
            return ['code' => $barangay->barangay, 'desc' => $barangayMap[$barangay->barangay] ?? $barangay->barangay];
        });

        return response()->json($barangays);
    }

    public function findBarangay(Request $request)
    {
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
        $request->validate([
            'first_name' => 'required|alpha|min:2|max:50',
            'middle_name' => 'nullable|alpha|max:50',
            'last_name' => 'required|alpha|min:2|max:50',
            'dob' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'gender' => 'required|in:Male,Female,Other',
            'email' => [
                'required',
                'email',
                Rule::unique('barangay_officials', 'email'),
                Rule::unique('barangay_staff', 'email'),
                Rule::unique('barangay_residents', 'email'),
                Rule::unique('barangay_captains', 'email'),
                Rule::unique('barangays', 'barangay_email')
            ],
            'contact_no' => [
                'required',
                'digits_between:10,15',
                Rule::unique('barangay_officials', 'contact_no'),
                Rule::unique('barangay_staff', 'contact_no'),
                Rule::unique('barangay_residents', 'contact_no'),
                Rule::unique('barangay_captains', 'contact_no'),
                Rule::unique('barangays', 'barangay_contact_number')
            ],
            'bric_no' => [
                'required',
                'alpha_num',
                'min:6',
                'max:20',
                Rule::unique('barangay_officials', 'bric_no'),
                Rule::unique('barangay_staff', 'bric_no'),
                Rule::unique('barangay_residents', 'bric_no'),
                Rule::unique('barangay_captains', 'bric')
            ],
        ]);
    
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
            case 'barangay_staff':
                $data['role'] = $request->input('role');
                Staff::create($data);
                break;
            case 'barangay_resident':
                Resident::create($data);
                break;
        }

        return redirect()->route('barangay_roles.showUnifiedLogin')->with('success', 'Registration completed successfully.');
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
            case 'barangay_staff':
                if (Auth::guard('barangay_staff')->attempt($credentials)) {
                    Log::info('Staff login successful');
                    $request->session()->regenerate();
                    return redirect()->route('barangay_staff.dashboard');
                }
                break;
            case 'barangay_resident':
                if (Auth::guard('barangay_resident')->attempt($credentials)) {
                    Log::info('Resident login successful');
                    $request->session()->regenerate();
                    return redirect()->route('barangay_resident.dashboard');
                }
                break;
        }
    
        Log::warning('Login failed for role: ' . $role);
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    
    public function showBarangayOfficialDashboard()
    {
        return view('barangay_official.bo-dashboard');
    }
    
    public function showStaffDashboard()
    {
        return view('barangay_staff.bs-dashboard');
    }
    
    public function showResidentDashboard()
    {
        return view('barangay_resident.br-dashboard');
    }    
}
