<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Household;
use App\Models\Barangay; // Assuming Barangay model contains the appearance settings
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HouseholdController extends Controller
{
    // Display the list of household members
    public function index()
    {
        $user = Auth::guard('barangay_resident')->user();
        $households = Household::where('resident_id', $user->id)->get();
        $appearanceSettings = $user->barangay ? $user->barangay->appearanceSettings : null;
        $role = 'barangay_resident';

        return view('barangay_resident.household-management.br-household-index', compact('households', 'appearanceSettings', 'role'));
    }

    // Show the form for creating new household members
    public function create()
    {
        $user = Auth::guard('barangay_resident')->user();
        $appearanceSettings = $user->barangay ? $user->barangay->appearanceSettings : null;
        $role = 'barangay_resident';

        return view('barangay_resident.household-management.br-household-create', compact('appearanceSettings', 'role'));
    }

    // Store the household members in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'residents.*.bric_no' => [
                'required',
                function($attribute, $value, $fail) {
                    $tables = [
                        ['table' => 'barangay_residents', 'field' => 'bric_no'],
                        ['table' => 'barangay_officials', 'field' => 'bric_no'],
                        ['table' => 'barangay_staff', 'field' => 'bric_no'],
                        ['table' => 'barangay_captains', 'field' => 'bric'],
                        ['table' => 'households', 'field' => 'bric_no'], // Check the households table as well
                    ];
                    Log::info("Validating BRIC number: $value");
                    foreach ($tables as $tableInfo) {
                        if (DB::table($tableInfo['table'])->where($tableInfo['field'], $value)->exists()) {
                            Log::info("BRIC number $value already exists in table {$tableInfo['table']}");
                            $fail('The BRIC number has already been taken.');
                        }
                    }
                }
            ],
            'residents.*.first_name' => 'required|string|max:255',
            'residents.*.middle_name' => 'nullable|string|max:255',
            'residents.*.last_name' => 'required|string|max:255',
            'residents.*.dob' => 'required|date',
            'residents.*.gender' => 'required|in:Male,Female,Other',
            'residents.*.is_employee' => 'nullable|boolean',
        ]);
    
        foreach ($validatedData['residents'] as $resident) {
            Log::info("Saving resident with BRIC number: {$resident['bric_no']}");
            DB::table('households')->insert([
                'resident_id' => auth()->user()->id,
                'first_name' => $resident['first_name'],
                'middle_name' => $resident['middle_name'],
                'last_name' => $resident['last_name'],
                'dob' => $resident['dob'],
                'gender' => $resident['gender'],
                'bric_no' => $resident['bric_no'],
                'is_employee' => $resident['is_employee'] ?? false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        return redirect()->route('households.index')->with('success', 'Household members added successfully.');
    }    
}
