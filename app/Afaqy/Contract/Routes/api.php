<?php

Route::prefix('v1/contracts')->middleware(['auth:api'])->group(function () {
    Route::get('/', 'ContractController@index')->middleware(['ability:owner,read-contract|read-dashboard']);
    Route::get('/export/excel', 'ContractController@exportExcel')->middleware(['ability:owner,read-contract']);
    Route::get('/export/pdf', 'ContractController@exportPdf')->middleware(['ability:owner,read-contract']);
    Route::get('/{id}', 'ContractController@show')->middleware(['ability:owner,read-contract']);
    Route::post('/', 'ContractController@store')->middleware(['ability:owner,create-contract']);
    Route::put('/{id}', 'ContractController@update')->middleware(['ability:owner,update-contract']);
    Route::delete('/', 'ContractController@destroyMany')->middleware(['ability:owner,delete-contract']);
    Route::delete('/{id}', 'ContractController@destroy')->middleware(['ability:owner,delete-contract']);
});
