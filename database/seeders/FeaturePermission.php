<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeaturePermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        FeaturePermission::create([
            'feature_id' => 1,
            'permissible_type' => 'App\\Models\\Staff',
            'permissible_id' => 1,
            'role' => 'staff',
            'can_view' => true,
            'can_edit' => false,
        ]);

        FeaturePermission::create([
            'feature_id' => 1,
            'permissible_type' => 'App\\Models\\BarangayOfficial',
            'permissible_id' => 1,
            'role' => 'official',
            'can_view' => true,
            'can_edit' => true,
        ]);
    }
}
