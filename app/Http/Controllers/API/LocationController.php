<?php

namespace App\Http\Controllers\API;

use App\Services\LocationService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function getProvincesByRegCode($regCode)
    {
        return $this->locationService->getProvincesByRegCode($regCode);
    }

    public function getCitiesByProvCode($provCode)
    {
        return $this->locationService->getCitiesByProvCode($provCode);
    }

    public function getBarangaysByCitymunCode($citymunCode)
    {
        return $this->locationService->getBarangaysByCitymunCode($citymunCode);
    }
}
