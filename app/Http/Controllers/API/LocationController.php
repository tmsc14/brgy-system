<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function getProvinces(Request $request)
    {
        $provinces = DB::table('geographic_data')
            ->where('regCode', $request->query('region'))
            ->select('provCode', 'provDesc')
            ->distinct()
            ->get();

        \Log::info('Provinces: ' . $provinces);

        return response()->json($provinces);
    }

    public function getCities(Request $request)
    {
        $cities = DB::table('geographic_data')
            ->where('provCode', $request->query('province'))
            ->select('citymunCode', 'citymunDesc')
            ->distinct()
            ->get();

        \Log::info('Cities: ' . $cities);

        return response()->json($cities);
    }

    public function getBarangays(Request $request)
    {
        $barangays = DB::table('geographic_data')
            ->where('citymunCode', $request->query('city'))
            ->select('brgyCode', 'brgyDesc')
            ->get();

        \Log::info('Barangays: ' . $barangays);

        return response()->json($barangays);
    }
}
