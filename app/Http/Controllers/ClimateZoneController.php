<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ClimateZoneController extends Controller
{

    public function climateZonesAll()
    {
        $zones = DB::select('select * from locations');

        return response()->json($zones);
    }

    public function climateZonesCode($code)
    {
        $zones = DB::select('select * from locations where Cls = ?', [$code]);
        ;

        return response()->json($zones);
    }

    public function climateZonesLat($lat, $lon)
    {
        $zones = DB::select('select * from locations where Lat = :lat and Lon = :lon', [$lat, $lon]);
        ;

        return response()->json($zones);
    }
}
