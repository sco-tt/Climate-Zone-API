<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

$app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers'], function ($app) {
    $app->get('location/{lat}/{lon}', 'ClimateZoneController@climateZonesLat');

    $app->get('kg-zone/{code}', 'ClimateZoneController@climateZonesCode');
});
