<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class LocationService
{
    protected $regions;
    protected $regionsIdLookup;

    protected $provinces;
    protected $provincesRegCodeLookup;
    protected $provincesProvCodeLookup;
    
    protected $cities;
    protected $citiesProvCodeLookup;
    protected $citiesCitymunCodeLookup;

    protected $barangays;
    protected $barangaysCityMunCodeLookup;
    protected $barangaysBrgyCodeLookup;

    public function __construct()
    {
        $this->regions = [];
        $this->regionsIdLookup = [];
        
        $this->provinces = [];
        $this->provincesRegCodeLookup = [];
        $this->provincesProvCodeLookup = [];

        $this->cities = [];
        $this->citiesProvCodeLookup = [];
        $this->citiesCitymunCodeLookup = [];

        $this->barangays = [];
        $this->barangaysCityMunCodeLookup = [];
        $this->barangaysBrgyCodeLookup = [];

        $this->loadLocationData();
    }

    public function getBarangayByBrgyCode($brgyCode)
    {
        return $this->barangaysBrgyCodeLookup[$brgyCode] ?? null;
    }

    public function getProvincesByRegCode($regCode)
    {
        return $this->provincesRegCodeLookup[$regCode] ?? null;
    }
    
    public function getCitiesByProvCode($provCode)
    {
        return $this->citiesProvCodeLookup[$provCode] ?? null;
    }

    public function getBarangaysByCitymunCode($citymunCode)
    {
        return $this->barangaysCityMunCodeLookup[$citymunCode] ?? null;
    }

    public function getAllBarangays()
    {
        return $this->barangays;
    }

    public function getAllRegions()
    {
        return $this->regions;
    }

    public function getAllProvinces()
    {
        return $this->provinces;
    }

    public function getAllCities()
    {
        return $this->regions;
    }

    protected function loadLocationData()
    {
        $this->loadLocationDataFromJson('refregion.json', 'REGION');
        $this->loadLocationDataFromJson('refprovince.json', 'PROVINCE');
        $this->loadLocationDataFromJson('refcitymun.json', 'CITY');
        $this->loadLocationDataFromJson('refbrgy.json', 'BARANGAY');
    }

    protected function loadLocationDataFromJson($jsonFileName, $locationType)
    {
        $jsonPath = base_path('public/json/' . $jsonFileName);
        $jsonData = File::get($jsonPath);
        $records = json_decode($jsonData, true)['RECORDS'];

        // Raw records
        switch ($locationType) {
            case 'REGION':
                $this->regions = $records;
                break;
            case 'PROVINCE':
                $this->provinces = $records;
                break;
            case 'CITY':
                $this->cities = $records;
                break;
            case 'BARANGAY':
                $this->barangays = $records;
                break;
        }

        // Lookups creation
        foreach ($records as $record) {
            switch ($locationType) {
                case 'REGION':
                    $this->regionsIdLookup[$record['id']] = $record;
                    break;
                case 'PROVINCE':
                    $this->provincesProvCodeLookup[$record['provCode']] = $record;
                    $this->provincesRegCodeLookup[$record['regCode']][] = $record;
                    break;
                case 'CITY':
                    $this->citiesCitymunCodeLookup[$record['citymunCode']] = $record;
                    $this->citiesProvCodeLookup[$record['provCode']][] = $record;
                    break;
                case 'BARANGAY':    
                    $this->barangaysBrgyCodeLookup[$record['brgyCode']] = $record;
                    $this->barangaysCityMunCodeLookup[$record['citymunCode']][] = $record;
                    break;
            }
        }
    }
}
