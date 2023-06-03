<?php

Route::prefix('v1/units')->middleware(['auth:api'])->group(function () {
    Route::get('/', 'UnitController@index')->middleware(['ability:owner,read-unit|create-contract|update-contract|read-dashboard']);
    Route::get('/export/excel', 'UnitController@exportExcel')->middleware(['ability:owner,read-unit']);
    Route::get('/export/pdf', 'UnitController@exportPdf')->middleware(['ability:owner,read-unit']);
    Route::get('/{id}', 'UnitController@show')->middleware(['ability:owner,read-unit']);
    Route::post('/', 'UnitController@store')->middleware(['ability:owner,create-unit']);
    Route::put('/{id}', 'UnitController@update')->middleware(['ability:owner,update-unit']);
    Route::delete('/', 'UnitController@destroyMany')->middleware(['ability:owner,delete-unit']);
    Route::delete('/{id}', 'UnitController@destroy')->middleware(['ability:owner,delete-unit']);
});
