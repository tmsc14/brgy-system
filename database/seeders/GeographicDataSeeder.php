<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GeographicDataSeeder extends Seeder
{
    public function run()
    {
        // Seed Regions
        $regions = json_decode(File::get(database_path('seeders/refregion.json')), true);
        foreach ($regions['RECORDS'] as $region) {
            DB::table('geographic_data')->insert([
                'regCode' => $region['regCode'],
                'regDesc' => $region['regDesc']
            ]);
        }

        // Seed Provinces
        $provinces = json_decode(File::get(database_path('seeders/refprovince.json')), true);
        foreach ($provinces['RECORDS'] as $province) {
            DB::table('geographic_data')->insert([
                'regCode' => $province['regCode'],
                'provCode' => $province['provCode'],
                'provDesc' => $province['provDesc']
            ]);
        }

        // Seed Cities/Municipalities
        $cities = json_decode(File::get(database_path('seeders/refcitymun.json')), true);
        foreach ($cities['RECORDS'] as $city) {
            DB::table('geographic_data')->insert([
                'regCode' => $city['regDesc'],
                'provCode' => $city['provCode'],
                'citymunCode' => $city['citymunCode'],
                'citymunDesc' => $city['citymunDesc']
            ]);
        }

        // Seed Barangays
        $barangays = json_decode(File::get(database_path('seeders/refbrgy.json')), true);
        foreach ($barangays['RECORDS'] as $barangay) {
            DB::table('geographic_data')->insert([
                'regCode' => $barangay['regCode'],
                'provCode' => $barangay['provCode'],
                'citymunCode' => $barangay['citymunCode'],
                'brgyCode' => $barangay['brgyCode'],
                'brgyDesc' => $barangay['brgyDesc']
            ]);
        }
    }
}
