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
use App\Models\SignupRequest;

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
                Rule::unique('signup_requests', 'email'),
                Rule::unique('barangays', 'barangay_email')
            ],
            'contact_no' => [
                'required',
                'digits_between:10,15',
                Rule::unique('barangay_officials', 'contact_no'),
                Rule::unique('barangay_staff', 'contact_no'),
                Rule::unique('barangay_residents', 'contact_no'),
                Rule::unique('barangay_captains', 'contact_no'),
                Rule::unique('signup_requests', 'contact_no'),
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
                Rule::unique('barangay_captains', 'bric'),
                Rule::unique('signup_requests', 'bric_no')
            ],
        ]);
    
        $request->session()->put('user_details', $request->only([
            'first_name', 'middle_name', 'last_name', 'dob', 'gender', 'email', 'contact_no', 'bric_no'
        ]));
        return redirect()->route('barangay_roles.showAccountDetails');
    }
    
    public function showAccountDetails()
    {
        if (!session('role') || !session('user_details')) {
            return redirect()->route('barangay_roles.showSelectRole');
        }
    
        $role = session('role');
        return view('auth.barangay_roles.account_details', compact('role'));
    }

    public function accountDetails(Request $request)
    {
        $role = $request->session()->get('role');
        $barangay_id = $request->session()->get('barangay_id');
        $user_details = $request->session()->get('user_details');
    
        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
                'confirmed'
            ],
            'valid_id' => 'required|mimes:jpeg,jpg,png|max:2048',
            'position' => $role === 'barangay_official' ? 'required|alpha_spaces' : '',
            'role' => $role === 'barangay_staff' ? 'required|alpha_spaces' : '',
        ]);
    
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
            'password' => Hash::make($request->input('password')),  // Hash the password here
        ];
    
        if ($request->hasFile('valid_id')) {
            $data['valid_id'] = $request->file('valid_id')->store('valid_ids', 'public');
        }
    
        SignupRequest::create([
            'first_name' => $user_details['first_name'],
            'middle_name' => $user_details['middle_name'],
            'last_name' => $user_details['last_name'],
            'dob' => $user_details['dob'],
            'gender' => $user_details['gender'],
            'email' => $user_details['email'],
            'contact_no' => $user_details['contact_no'],
            'bric_no' => $user_details['bric_no'],
            'barangay_id' => $barangay_id,
            'password' => Hash::make($request->input('password')), // Ensure the password is hashed here
            'valid_id' => $data['valid_id'],
            'position' => $role === 'barangay_official' ? $request->input('position') : null,
            'role' => $role === 'barangay_staff' ? $request->input('role') : null,
            'user_type' => $role,  // Ensure the user_type is set
        ]);              
        
        return redirect()->route('barangay_roles.showUnifiedLogin')->with('success', 'Registration request submitted successfully.');
    }    

    public function showUnifiedLogin()
    {
        $barangays = DB::table('barangays')->get(); // Fetch all barangays
        return view('auth.barangay_roles.unified_login', compact('barangays'));
    }
    
    public function unifiedLogin(Request $request)
    {
        Log::info('Login attempt started');
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',
            'barangay' => 'required|exists:barangays,id'
        ]);
    
        $credentials = $request->only('email', 'password');
        $role = $request->input('role');
        $barangay_id = $request->input('barangay');
    
        Log::info('Login role: ' . $role);
    
        $user = null;
    
        switch ($role) {
            case 'barangay_official':
                $user = BarangayOfficial::where('email', $credentials['email'])->where('barangay_id', $barangay_id)->first();
                break;
            case 'barangay_staff':
                $user = Staff::where('email', $credentials['email'])->where('barangay_id', $barangay_id)->first();
                break;
            case 'barangay_resident':
                $user = Resident::where('email', $credentials['email'])->where('barangay_id', $barangay_id)->first();
                break;
        }
    
        if ($user) {
            if (Hash::check($credentials['password'], $user->password)) {
                Auth::guard($role)->login($user);
                Log::info(ucfirst($role) . ' login successful');
                $request->session()->regenerate();
    
                return redirect()->route("{$role}.dashboard");
            }
    
            Log::warning('Login failed due to incorrect password');
            return back()->withErrors([
                'password' => 'The provided password is incorrect.',
            ]);
        }
    
        Log::warning('Login failed for role: ' . $role);
        return back()->withErrors([
            'barangay' => 'The provided credentials do not match our records or the selected barangay is incorrect.',
        ]);
    }    
    
    public function showBarangayOfficialDashboard()
    {
        $user = Auth::guard('barangay_official')->user();
        $appearanceSettings = $user->barangay ? $user->barangay->appearanceSettings : null;
    
        $role = 'barangay_official';
        return view('barangay_official.bo-dashboard', compact('user', 'appearanceSettings', 'role'));
    }
    
    public function showStaffDashboard()
    {
        $user = Auth::guard('barangay_staff')->user();
        $appearanceSettings = $user->barangay ? $user->barangay->appearanceSettings : null;
    
        $role = 'barangay_staff';
        return view('barangay_staff.bs-dashboard', compact('user', 'appearanceSettings', 'role'));
    }
    
    public function showResidentDashboard()
    {
        $user = Auth::guard('barangay_resident')->user();
        $appearanceSettings = $user->barangay ? $user->barangay->appearanceSettings : null;
    
        $role = 'barangay_resident';
        return view('barangay_resident.br-dashboard', compact('user', 'appearanceSettings', 'role'));
    }    
}
