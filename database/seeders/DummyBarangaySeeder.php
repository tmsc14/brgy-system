<?php

namespace Database\Seeders;

use App\Helpers\ThemeHelper;
use App\Models\AppearanceSetting;
use App\Models\Barangay;
use App\Models\BarangayFeature;
use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class DummyBarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangay = Barangay::create([
            'name' => 'Sindalan',
            'display_name' => 'Sindalan',
            'email' => 'sindalan@email.com',
            'contact_number' => '1234567890',
            'region_code' => '03',
            'province_code' => '0354',
            'city_code' => '035416',
            'barangay_code' => '035416036',
            'address_line_one' => 'Address',
            'is_setup_complete' => true
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
            'email' => 'captain1@email.com',
            'email_verified_at' => now('UTC'),
            'password' => Hash::make('Password1!')
        ]);

        // Create the staff record of the barangay captain
        $barangayCaptainStaff = Staff::create([
            'barangay_id' => $barangay->id,
            'user_id' => $barangayCaptainUser->id,
            'first_name' => 'Test',
            'middle_name' => '',
            'last_name' => 'Captain',
            'gender' => 'Male',
            'email' => 'captain1@email.com',
            'contact_number' => '1234567890',
            'date_of_birth' => '1999-04-19',
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
            'text_color' => ThemeHelper::convertHexToRGB(AppearanceSetting::DEFAULT_TEXT_COLOR)
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
                    'is_enabled' => false
                ];
            }
        }

        BarangayFeature::insert($featuresToInsert);

        // Official/Staff
        // $user = User::create([
        //     'barangay_id' => $barangay->id,
        //     'email' => $form->email,
        //     'email_verified_at' => now('UTC'),
        //     'password' => Hash::make($form->password)
        // ]);

        // Staff::create([
        //     'barangay_id' => $barangayId,
        //     'user_id' => $user->id,
        //     'first_name' => $form->firstName,
        //     'middle_name' => $form->middleName,
        //     'last_name' => $form->lastName,
        //     'gender' => $form->gender,
        //     'email' => $form->email,
        //     'contact_number' => $form->contactNumber,
        //     'date_of_birth' => $form->dateOfBirth,
        //     'is_master' => false,
        //     'is_active' => false,
        //     'title' => $roleName,
        //     'position' => $staffForm->officialPosition ?? $staffForm->staffRole
        // ]);

        // $validIdPath = $form->validId->store('photos/' . $barangayId . '/validIds/' .  strtolower($roleName) . '/' . $user->id);

        // SignupRequest::create([
        //     'barangay_id' => $barangayId,
        //     'user_id' => $user->id,
        //     'first_name' => $form->firstName,
        //     'middle_name' => $form->middleName,
        //     'last_name' => $form->lastName,
        //     'valid_id' => $validIdPath,
        //     'user_type' => $roleName,
        //     'position' => $staffForm->officialPosition ?? $staffForm->staffRole,
        //     'status' => SignupRequest::PENDING_STATUS
        // ]);

        // $role = Role::where('name', $roleName)->first();

        // UserRole::create([
        //     'barangay_id' => $barangayId,
        //     'user_id' => $user->id,
        //     'role_id' => $role->id
        // ]);
    }
}
