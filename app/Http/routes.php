<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

$app->get('/', function () use ($app) {
    return 'Welcome to the Climate Zone API.';
});

$app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers'], function ($app) {

    $app->get('all', 'ClimateZoneController@climateZonesAll');

    $app->get('location/{lat}/{lon}', 'ClimateZoneController@climateZonesLat');

    $app->get('kg-zone/{code}', 'ClimateZoneController@climateZonesCode');

});
