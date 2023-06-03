<?php


Route::prefix('v1/contractors')->middleware(['auth:api'])->group(function () {
    Route::get('/', 'ContractorController@index')->middleware([
        'ability:owner,read-contractor|create-contract|update-contract|create-unit|update-unit|read-dashboard',
    ]);
    Route::get('/export/excel', 'ContractorController@exportExcel')->middleware(['ability:owner,read-contractor']);
    Route::get('/export/pdf', 'ContractorController@exportPdf')->middleware(['ability:owner,read-contractor']);
    Route::get('/{id}/units', 'ContractorController@units')->middleware([
        'ability:owner,read-contractor|create-contract|update-contract',
    ]);
    Route::get('/{id}', 'ContractorController@show')->middleware(['ability:owner,read-contractor']);
    Route::post('/', 'ContractorController@store')->middleware(['ability:owner,create-contractor']);
    Route::get('/companies', 'ContractorController@avlCompanies')->middleware(['ability:owner,create-contractor,update-contractor']);
    Route::put('/{id}', 'ContractorController@update')->middleware(['ability:owner,update-contractor']);
    Route::delete('/', 'ContractorController@destroyMany')->middleware(['ability:owner,delete-contractor']);
    Route::delete('/{id}', 'ContractorController@destroy')->middleware(['ability:owner,delete-contractor']);
});
