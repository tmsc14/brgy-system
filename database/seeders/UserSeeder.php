<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barangay;
use App\Models\Staff;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangay = Barangay::create([
            'id' => 7693,
            'name' => 'Sindalan',
            'display_name' => 'Sindalan',
            'description' => 'This is the BrgyPlus account of Barangay Sindalan!',
            'email' => 'sindalan@email.com',
            'contact_number' => '0454554555',
            'region_id' => '3',
            'province_id' => '13',
            'city_id' => '302'
        ]);

        $barangayCaptainUser = User::create([
            'barangay_id' => $barangay->id,
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password')
        ]);

        $barangayCaptainStaff = Staff::create([
            'barangay_id' => $barangay->id,
            'user_id' => $barangayCaptainUser->id,
            'email_verified_at' => now(),
            'password' => bcrypt('password')
        ]);

        User::create([
            'name' => 'Default User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
    }
}
