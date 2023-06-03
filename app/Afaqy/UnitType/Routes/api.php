<?php

Route::prefix('v1/unit-types')->middleware(['auth:api'])->group(function () {
    Route::get('/', 'UnitTypeController@index')->middleware(['ability:owner,read-unit-type|create-unit|update-unit|read-dashboard']);
    Route::get('/export/excel', 'UnitTypeController@exportExcel')->middleware(['ability:owner,read-unit-type']);
    Route::get('/export/pdf', 'UnitTypeController@exportPdf')->middleware(['ability:owner,read-unit-type']);
    Route::get('/{id}', 'UnitTypeController@show')->middleware(['ability:owner,read-unit-type']);
    Route::post('/', 'UnitTypeController@store')->middleware(['ability:owner,create-unit-type']);
    Route::put('/{id}', 'UnitTypeController@update')->middleware(['ability:owner,update-unit-type']);
    Route::delete('/', 'UnitTypeController@destroyMany')->middleware(['ability:owner,delete-unit-type']);
    Route::delete('/{id}', 'UnitTypeController@destroy')->middleware(['ability:owner,delete-unit-type']);
});
