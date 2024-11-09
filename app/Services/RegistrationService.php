<?php

namespace App\Services;

use App\Helpers\ThemeHelper;
use App\Livewire\Forms\RegistrationForm;
use App\Livewire\Forms\ResidentFieldsForm;
use App\Livewire\Forms\StaffRegistrationFieldsForm;
use App\Models\AppearanceSetting;
use App\Models\Barangay;
use App\Models\BarangayFeature;
use App\Models\BarangayOfficial;
use App\Models\Household;
use App\Models\Resident;
use App\Models\Role;
use App\Models\SignupRequest;
use App\Models\Staff;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Config;
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

        DB::transaction(function () use ($barangayInfo, $form)
        {
            // Create barangay with partial data
            $barangay = Barangay::create([
                'name' => $barangayInfo['brgyDesc'],
                'display_name' => $barangayInfo['brgyDesc'],
                'email' => '',
                'contact_number' => '',
                'region_code' => $barangayInfo['regCode'],
                'province_code' => $barangayInfo['provCode'],
                'city_code' => $barangayInfo['citymunCode'],
                'barangay_code' => $barangayInfo['brgyCode'],
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
                'is_master' => true,
                'is_active' => true,
                'title' => Role::CAPTAIN
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
                'theme_color' => ThemeHelper::convertHexToRGB(AppearanceSetting::DEFAULT_THEME_COLOR),
                'primary_color' => ThemeHelper::convertHexToRGB(AppearanceSetting::DEFAULT_PRIMARY_COLOR),
                'secondary_color' => ThemeHelper::convertHexToRGB(AppearanceSetting::DEFAULT_SECONDARY_COLOR),
                'text_color' => ThemeHelper::convertHexToRGB(AppearanceSetting::DEFAULT_TEXT_COLOR),
                'content_color' => ThemeHelper::convertHexToRGB(AppearanceSetting::DEFAULT_CONTENT_COLOR),
            ]);

            // Default features
            $configData = Config::get('features');

            $featuresToInsert = [];

            foreach ($configData as $category => $features)
            {
                foreach ($features as $featureName)
                {
                    $featuresToInsert[] = [
                        'barangay_id' => $barangay->id,
                        'category' => $category,
                        'name' => $featureName,
                        'description' => $featureName, // Not being used for now, just added because could be useful. Remove this comment when we fix this
                        'is_enabled' => true
                    ];
                }
            }

            BarangayFeature::insert($featuresToInsert);

            BarangayOfficial::create([
                'barangay_id' => $barangay->id,
                'name' => $form->firstName . ' ' . $form->middleName . ' ' . $form->lastName,
                'rank' => 0,
                'title' => 'Barangay Captain',
                'photo' => null,
                'contact_number' => $form->contactNumber
            ]);

        });

        // Clear session data
        session()->flush();

        return redirect()->route('login', ['role' => 'staff'])->with('success', 'Registration successful! Please log in.');
    }

    public function registerStaff($roleName, RegistrationForm $form, StaffRegistrationFieldsForm $staffForm)
    {
        $barangayId = $staffForm->selectedBarangayId;

        DB::transaction(function () use ($barangayId, $roleName, $form, $staffForm)
        {
            $user = User::create([
                'barangay_id' => $barangayId,
                'email' => $form->email,
                'email_verified_at' => now('UTC'),
                'password' => Hash::make($form->password)
            ]);

            Staff::create([
                'barangay_id' => $barangayId,
                'user_id' => $user->id,
                'first_name' => $form->firstName,
                'middle_name' => $form->middleName,
                'last_name' => $form->lastName,
                'gender' => $form->gender,
                'email' => $form->email,
                'contact_number' => $form->contactNumber,
                'date_of_birth' => $form->dateOfBirth,
                'is_master' => false,
                'is_active' => false,
                'title' => $roleName,
                'position' => $staffForm->officialPosition ?? $staffForm->staffRole
            ]);

            $validIdPath = $form->validId->store('photos/' . $barangayId . '/validIds/' .  strtolower($roleName) . '/' . $user->id);

            SignupRequest::create([
                'barangay_id' => $barangayId,
                'user_id' => $user->id,
                'first_name' => $form->firstName,
                'middle_name' => $form->middleName,
                'last_name' => $form->lastName,
                'valid_id' => $validIdPath,
                'user_type' => $roleName,
                'position' => $staffForm->officialPosition ?? $staffForm->staffRole,
                'status' => SignupRequest::PENDING_STATUS
            ]);

            $role = Role::where('name', $roleName)->first();

            UserRole::create([
                'barangay_id' => $barangayId,
                'user_id' => $user->id,
                'role_id' => $role->id
            ]);
        });

        session()->flush();

        return redirect()->route('login', ['role' => 'staff'])->with('success', 'Registration successful! Please log in.');
    }

    public function registerResident($barangayId, RegistrationForm $form, ResidentFieldsForm $residentForm)
    {
        DB::transaction(function () use ($barangayId, $form, $residentForm)
        {
            $user = User::create([
                'barangay_id' => $barangayId,
                'email' => $form->email,
                'email_verified_at' => now('UTC'),
                'password' => Hash::make($form->password)
            ]);

            $household = Household::create([
                'barangay_id' => $barangayId,
                'household_head_user_id' => $user->id,
                'street_address' => $residentForm->street_address,
                'purok' => '',
                'sitio' => '',
            ]);

            $validIdPath = $form->validId->store('photos/' . $barangayId . '/validIds/resident/' . $user->id);

            Resident::create([
                'barangay_id' => $barangayId,
                'user_id' => $user->id,
                'household_id' => $household->id,
                'first_name' => $form->firstName,
                'middle_name' => $form->middleName,
                'last_name' => $form->lastName,
                'gender' => $form->gender,
                'email' => $form->email,
                'contact_number' => $form->contactNumber,
                'date_of_birth' => $form->dateOfBirth,
                'is_head_of_household' => true,
                'ethnicity' => $residentForm->ethnicity,
                'religion' => $residentForm->religion,
                'civil_status' => $residentForm->civil_status,
                'valid_id' => $validIdPath,
                'is_temporary_resident' => $residentForm->is_temporary_resident,
                'is_pwd' => $residentForm->is_pwd,
                'is_voter' => $residentForm->is_voter,
                'is_employed' => $residentForm->is_employed,
                'is_active' => false,
                'is_birth_registered' => $residentForm->is_birth_registered,
                'is_literate' => $residentForm->is_literate,
                'is_single_parent' => $residentForm->is_single_parent,
            ]);

            SignupRequest::create([
                'barangay_id' => $barangayId,
                'user_id' => $user->id,
                'first_name' => $form->firstName,
                'middle_name' => $form->middleName,
                'last_name' => $form->lastName,
                'valid_id' => $validIdPath,
                'user_type' => 'Resident',
                'position' => '',
                'status' => 'pending',  // Default status for signup request
            ]);

            $role = Role::where('name', 'Resident')->first();

            UserRole::create([
                'barangay_id' => $barangayId,
                'user_id' => $user->id,
                'role_id' => $role->id
            ]);
        });

        session()->flush();

        return redirect()->route('login', ['role' => 'resident'])->with('success', 'Registration successful! Please log in.');
    }
}
