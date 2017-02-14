<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ClimateZoneController extends Controller
{
    private function roundCoordinates($rawCoord)
    {
        $decimal = fmod($rawCoord, 1);

        if ($decimal >= 0 && $decimal <= 0.5) {
            $coord = $rawCoord + (0.25 - $decimal);
        }

        if ($decimal > 0.5 && $decimal < 1) {
            $coord = $rawCoord + (0.75 - $decimal);
        }

        if ($decimal >= -0.5 && $decimal  < 0) {
            $coord = $rawCoord + (-0.25 - $decimal);
        }

        if ($decimal > -1.00 && $decimal < -0.5) {
            $coord = $rawCoord + (-0.75 - $decimal);
        }

        return $coord;
    }

    public function climateZonesAll()
    {
        $zones = DB::select('select * from locations');

        return response()->json($zones);
    }

    public function climateZonesCode($code)
    {
        $zones = DB::select('select lat, lon, koppen_geiger_zone from locations where koppen_geiger_zone = ?', [$code]);
        ;

        if (!empty($zones)) {
            $output['locations'] = $zones;
        } else {
            $output['error'] = 'Could not find a matching climate zone code';
        }

        return response()->json($output);
    }

    public function climateZonesLat($latRaw, $lonRaw)
    {
        $lat = (float)$this->roundCoordinates($latRaw);
        $lon = (float)$this->roundCoordinates($lonRaw);

        $zones = DB::select(
            'SELECT locations.lat, locations.lon, locations.koppen_geiger_zone, zone_descriptions.zone_description
            FROM locations
            LEFT JOIN zone_descriptions
            ON zone_descriptions.zone_code = locations.koppen_geiger_zone
            WHERE locations.lat=:lat and locations.lon=:lon',
            [$lat, $lon]
        );

        if (!empty($zones)) {
            $output['request_values'] =
                array(
                    'lat' => (float)$latRaw,
                    'lon' => (float)$lonRaw
                );
            $output['return_values'] = $zones;
        } else {
            $output['error'] = 'Could not find data for the supplied latitude/longitude pair. Please double check your values.';
        }

        return response()->json($output);
    }
}
