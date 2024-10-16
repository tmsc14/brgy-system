<?php

namespace App\Services;

use App\Livewire\Forms\RegistrationForm;
use App\Models\AppearanceSetting;
use App\Models\Barangay;
use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class RegistrationService
{
    protected LocationService $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function initializeBarangayAndCaptain($barangayCode, RegistrationForm $form)
    {
        $barangayInfo = $this->locationService->getBarangayByBrgyCode($barangayCode);
        $password = $form->password;

        DB::transaction(function () use ($barangayInfo, $password, $form)
        {
            // Create barangay with partial data
            $barangay = Barangay::create([
                'name' => $barangayInfo['brgyDesc'],
                'display_name' => $barangayInfo['brgyDesc'],
                'description' => '',
                'email' => '',
                'contact_number' => '',
                'region_code' => $barangayInfo['regCode'],
                'province_code' => $barangayInfo['provCode'],
                'city_code' => $barangayInfo['citymunCode'],
                'barangay_code' => $barangayInfo['brgyCode'],
                'barangay_office_address' => '',
                'address_line_one' => ''
            ]);

            // Create the default roles (barangay captain, official, staff, and resident)
            $barangayCaptainRole = Role::create([
                'barangay_id' => $barangay->id,
                'name' => Role::CAPTAIN
            ]);

            Role::create([
                'barangay_id' => $barangay->id,
                'name' => Role::OFFICIAL
            ]);

            Role::create([
                'barangay_id' => $barangay->id,
                'name' => Role::STAFF
            ]);

            Role::create([
                'barangay_id' => $barangay->id,
                'name' => Role::RESIDENT
            ]);

            // Create the Barangay Captain
            $barangayCaptainUser = User::create([
                'barangay_id' => $barangay->id,
                'email' => $form->email,
                'email_verified_at' => now('UTC'),
                'password' => Hash::make($form->password)
            ]);

            // Create the staff record of the barangay captain
            $barangayCaptainStaff = Staff::create([
                'barangay_id' => $barangay->id,
                'user_id' => $barangayCaptainUser->id,
                'first_name' => $form->firstName,
                'middle_name' => $form->middleName,
                'last_name' => $form->lastName,
                'gender' => $form->gender,
                'email' => $form->email,
                'contact_number' => $form->contactNumber,
                'date_of_birth' => $form->dateOfBirth,
                'bric_number' => $form->bricNumber,
                'is_master' => true,
                'is_active' => true
            ]);

            // Assign the captain role to the captain user
            UserRole::create([
                'barangay_id' => $barangay->id,
                'user_id' => $barangayCaptainUser->id,
                'role_id' => $barangayCaptainRole->id
            ]);

            // Default appearance settings
            AppearanceSetting::create([
                'barangay_id' => $barangay->id,
                'theme_color' => AppearanceSetting::DEFAULT_THEME_COLOR,
                'primary_color' => AppearanceSetting::DEFAULT_PRIMARY_COLOR,
                'secondary_color' => AppearanceSetting::DEFAULT_SECONDARY_COLOR,
                'text_color' => AppearanceSetting::DEFAULT_TEXT_COLOR
            ]);

            // Default appearance settings
            AppearanceSetting::create([
                'barangay_id' => $barangay->id,
                'theme_color' => AppearanceSetting::DEFAULT_THEME_COLOR,
                'primary_color' => AppearanceSetting::DEFAULT_PRIMARY_COLOR,
                'secondary_color' => AppearanceSetting::DEFAULT_SECONDARY_COLOR,
                'text_color' => AppearanceSetting::DEFAULT_TEXT_COLOR
            ]);
        });

        // Clear session data
        session()->flush();

        return redirect()->route('login.staff')->with('success', 'Registration successful! Please log in.');
    }
}
