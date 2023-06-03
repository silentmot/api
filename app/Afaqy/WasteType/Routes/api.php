<?php

Route::prefix('v1/waste-types')->middleware(['auth:api'])->group(function () {
    Route::get('/', 'WasteTypeController@index')->middleware([
        'ability:owner,read-waste-type|create-unit-type|update-unit-type|create-unit|update-unit|read-dashboard',
    ]);
    Route::get('/export/excel', 'WasteTypeController@exportExcel')->middleware(['ability:owner,read-waste-type']);
    Route::get('/export/pdf', 'WasteTypeController@exportPdf')->middleware(['ability:owner,read-waste-type']);
    Route::get('/{id}', 'WasteTypeController@show')->middleware(['ability:owner,read-waste-type']);
    Route::post('/', 'WasteTypeController@store')->middleware(['ability:owner,create-waste-type']);
    Route::put('/{id}', 'WasteTypeController@update')->middleware(['ability:owner,update-waste-type']);
    Route::delete('/', 'WasteTypeController@destroyMany')->middleware(['ability:owner,delete-waste-type']);
    Route::delete('/{id}', 'WasteTypeController@destroy')->middleware(['ability:owner,delete-waste-type']);
});
