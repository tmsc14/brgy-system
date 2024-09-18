<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    public function run()
    {
        // Statistics Features
        Feature::create(['name' => 'residents_enabled', 'label' => 'Number of Residents', 'category' => 'statistics']);
        Feature::create(['name' => 'households_enabled', 'label' => 'Number of Households', 'category' => 'statistics']);
        Feature::create(['name' => 'gender_enabled', 'label' => 'Gender Demographics', 'category' => 'statistics']);
        Feature::create(['name' => 'age_demographics_enabled', 'label' => 'Age Demographics', 'category' => 'statistics']);
        Feature::create(['name' => 'renters_enabled', 'label' => 'Number of Renters', 'category' => 'statistics']);
    }
}
