<?php

Route::prefix('v1/devices')->middleware(['auth:api'])->group(function () {
    Route::get('/', 'DeviceController@index')->middleware(['ability:owner,read-device']);
    Route::get('/export/excel', 'DeviceController@exportExcel')->middleware(['ability:owner,read-device']);
    Route::get('/export/pdf', 'DeviceController@exportPdf')->middleware(['ability:owner,read-device']);
});
