<?php

Route::prefix('v1/slf')->group(function () {
    Route::post('/token', 'Integration\AuthController@token');

    Route::middleware(['client:slf', 'slf.same.request', 'locale:en'])->group(function () {
        Route::post('/car_information', 'SLFController@carInformation');
        Route::post('/car_weight', 'SLFController@takeCarWeight');
        Route::get('/entrance_scale_zones', 'SLFController@getEntranceScaleZones');
        Route::post('/gate_info', 'SLFController@gateInfo');
    });

    Route::middleware('client:slf')->group(function () {
        Route::get('/token-test', 'SLFController@testToken');
    });
});

Route::prefix('v1/avl')->group(function () {
    Route::post('/token', 'Integration\AuthController@token');

    Route::middleware(['client:avl', 'locale:en'])->group(function () {
        Route::post('/unit_enter_zone', 'Integration\AvlController@enterZone');
        Route::post('/unit_final_destination', 'Integration\AvlController@finalDestination');
    });
});
