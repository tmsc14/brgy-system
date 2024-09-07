<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangayFeatureSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Feature;

class BarangayStaffController extends Controller
{
    public function showStaffStatistics()
    {
        $user = Auth::guard('barangay_staff')->user();
        $barangay = $user->barangay;
        $role = 'barangay_staff';
    
        if (!$barangay) {
            return redirect()->back()->with('error', 'No barangay found for this user.');
        }
    
        $appearanceSettings = $barangay->appearanceSettings;
    
        // Fetch the enabled features for this barangay
        $enabledFeatures = DB::table('barangay_feature_settings')
                            ->where('barangay_id', $barangay->id)
                            ->where('is_enabled', true)
                            ->pluck('feature_id')
                            ->toArray();
    
        // Get all features to display in the view
        $features = Feature::whereIn('id', $enabledFeatures)->get();
    
        // Fetch number of residents for this barangay
        $residentsCount = DB::table('barangay_residents')->where('barangay_id', $barangay->id)->count();
    
        // Fetch number of households for this barangay by joining the 'households' and 'barangay_residents' tables
        $householdsCount = DB::table('households')
                            ->join('barangay_residents', 'households.resident_id', '=', 'barangay_residents.id')
                            ->where('barangay_residents.barangay_id', $barangay->id)
                            ->count();
    
        // If you need the total count of residents and household members, you can add them together
        $totalResidentsCount = $residentsCount + $householdsCount;
    
        return view('barangay_staff.statistics.bs-statistics', compact('barangay', 'features', 'totalResidentsCount', 'householdsCount', 'appearanceSettings', 'role'));
    }      
}