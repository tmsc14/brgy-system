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
            ->distinct()
            ->pluck('provDesc', 'provCode');

        return response()->json($provinces);
    }

    public function getCities(Request $request)
    {
        $cities = DB::table('geographic_data')
            ->where('provCode', $request->query('province'))
            ->distinct()
            ->pluck('citymunDesc', 'citymunCode');

        return response()->json($cities);
    }

    public function getBarangays(Request $request)
    {
        $barangays = DB::table('geographic_data')
            ->where('citymunCode', $request->query('city'))
            ->pluck('brgyDesc', 'brgyCode');

        return response()->json($barangays);
    }
}
