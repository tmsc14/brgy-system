<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangayFeatureSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Feature;

class BarangayOfficialController extends Controller
{
    public function showOfficialStatistics()
    {
        $user = Auth::guard('barangay_official')->user();
        $barangay = $user->barangay;
        $role = 'barangay_official';
    
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
    
        // Total residents including household members
        $totalResidentsCount = $residentsCount + $householdsCount;
    
        // Gender Demographics
        $genderDemographicsResidents = DB::table('barangay_residents')
            ->select(DB::raw('gender, COUNT(*) as count'))
            ->where('barangay_id', $barangay->id)
            ->groupBy('gender')
            ->get();
    
        $genderDemographicsHouseholds = DB::table('households')
            ->join('barangay_residents', 'households.resident_id', '=', 'barangay_residents.id')
            ->where('barangay_residents.barangay_id', $barangay->id)
            ->select(DB::raw('households.gender, COUNT(*) as count'))
            ->groupBy('households.gender')
            ->get();
    
        $genderDemographics = $genderDemographicsResidents->merge($genderDemographicsHouseholds)
            ->groupBy('gender')
            ->map(function ($group) {
                return $group->sum('count');
            });
    
        // Age Demographics (Group by Age Ranges)
        $ageDemographicsResidents = DB::table('barangay_residents')
            ->select(DB::raw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age'))
            ->where('barangay_id', $barangay->id)
            ->get();
    
        $ageDemographicsHouseholds = DB::table('households')
            ->join('barangay_residents', 'households.resident_id', '=', 'barangay_residents.id')
            ->where('barangay_residents.barangay_id', $barangay->id)
            ->select(DB::raw('TIMESTAMPDIFF(YEAR, households.dob, CURDATE()) AS age'))
            ->get();
    
        $ageDemographics = $ageDemographicsResidents->merge($ageDemographicsHouseholds)
            ->groupBy(function ($person) {
                $age = $person->age;
                if ($age < 18) {
                    return 'children';
                } elseif ($age >= 18 && $age < 60) {
                    return 'adults';
                } else {
                    return 'senior_citizens';
                }
            })->map(function ($group) {
                return count($group);
            });
    
        return view('barangay_official.statistics.bo-statistics', compact('barangay', 'features', 'totalResidentsCount', 'householdsCount', 'genderDemographics', 'ageDemographics', 'appearanceSettings', 'role'));
    }
}
