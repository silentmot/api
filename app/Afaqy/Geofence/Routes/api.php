<?php

Route::prefix('v1/geofences')->middleware(['auth:api'])->group(function () {
    Route::get('/', 'GeofenceController@index')->middleware(['ability:owner,read-geofence|create-waste-type|update-waste-type']);
    Route::get('/export/excel', 'GeofenceController@exportExcel')->middleware(['ability:owner,read-geofence']);
    Route::get('/export/pdf', 'GeofenceController@exportPdf')->middleware(['ability:owner,read-geofence']);
    Route::get('/{id}', 'GeofenceController@show')->middleware(['ability:owner,read-geofence']);
    Route::post('/', 'GeofenceController@store')->middleware(['ability:owner,create-geofence']);
    Route::put('/{id}', 'GeofenceController@update')->middleware(['ability:owner,update-geofence']);
    Route::delete('/', 'GeofenceController@destroyMany')->middleware(['ability:owner,delete-geofence']);
    Route::delete('/{id}', 'GeofenceController@destroy')->middleware(['ability:owner,delete-geofence']);
});
