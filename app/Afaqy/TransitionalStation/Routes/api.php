<?php

Route::prefix('v1/transitional-station')->middleware(['auth:api'])->group(function () {
    Route::get('/', 'TransitionalStationController@index')->middleware([
        'ability:owner,read-transitional-station|create-contract|update-contract',
    ]);
    Route::get('/export/excel', 'TransitionalStationController@exportExcel')->middleware(['ability:owner,read-transitional-station']);
    Route::get('/export/pdf', 'TransitionalStationController@exportPdf')->middleware(['ability:owner,read-transitional-station']);
    Route::get('/{id}/contracts', 'TransitionalStationController@contracts')->middleware(['ability:owner,read-transitional-station']);
    Route::get('/{id}', 'TransitionalStationController@show')->middleware(['ability:owner,read-transitional-station']);
    Route::post('/', 'TransitionalStationController@store')->middleware(['ability:owner,create-transitional-station,read-district']);
    Route::put('/{id}', 'TransitionalStationController@update')->middleware(['ability:owner,update-transitional-station']);
    Route::delete('/', 'TransitionalStationController@destroyMany')->middleware(['ability:owner,delete-transitional-station']);
    Route::delete('/{id}', 'TransitionalStationController@destroy')->middleware(['ability:owner,delete-transitional-station']);
});
