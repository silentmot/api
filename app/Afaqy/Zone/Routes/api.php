<?php

Route::prefix('v1/zones')->middleware('auth:api')->group(function () {
    Route::get('/', 'ZoneController@index')->middleware(['ability:owner,read-zone|create-waste-type|update-waste-type']);
    Route::get('/export/excel', 'ZoneController@exportExcel')->middleware(['ability:owner,read-zone']);
    Route::get('/export/pdf', 'ZoneController@exportPdf')->middleware(['ability:owner,read-zone']);
});
