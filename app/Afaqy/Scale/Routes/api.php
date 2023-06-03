<?php

Route::prefix('v1/scales')->middleware(['auth:api'])->group(function () {
    Route::get('/', 'ScaleController@index')->middleware(['ability:owner,read-scale']);
    Route::get('/export/excel', 'ScaleController@exportExcel')->middleware(['ability:owner,read-scale']);
    Route::get('/export/pdf', 'ScaleController@exportPdf')->middleware(['ability:owner,read-scale']);
});
