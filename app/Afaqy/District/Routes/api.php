<?php

Route::prefix('v1/districts')->middleware(['auth:api'])->group(function () {
    Route::get('/', 'DistrictController@index')->middleware([
        'ability:owner,read-district|create-contract|update-contract|create-permission|create-transitional-station|update-transitional-station',
    ]);
    Route::get('/export/excel', 'DistrictController@exportExcel')->middleware(['ability:owner,read-district']);
    Route::get('/export/pdf', 'DistrictController@exportPdf')->middleware(['ability:owner,read-district']);
    Route::get('/{id}/neighborhoods', 'DistrictController@districtNeighborhoods')->middleware([
        'ability:owner,read-district|create-contract|update-contract',
    ]);
    Route::get('/{id}/contracts', 'DistrictController@contracts')->middleware(['ability:owner,read-district']);
    Route::get('/{id}', 'DistrictController@show')->middleware(['ability:owner,read-district']);
    Route::post('/', 'DistrictController@store')->middleware(['ability:owner,create-district']);
    Route::put('/{id}', 'DistrictController@update')->middleware(['ability:owner,update-district']);
    Route::delete('/', 'DistrictController@destroyMany')->middleware(['ability:owner,delete-district']);
    Route::delete('/{id}', 'DistrictController@destroy')->middleware(['ability:owner,delete-district']);
});

Route::prefix('v1/neighborhood')->middleware(['auth:api'])->group(function () {
    Route::get('/{id}/contracts', 'NeighborhoodController@contracts')->middleware(['ability:owner,read-district']);
});
