<?php

Route::prefix('v1/entrance-permissions')->middleware(['auth:api'])->group(function () {
    Route::get('/', 'EntrancePermissionController@index')->middleware(['ability:owner,read-entrance']);
    Route::get('/export/excel', 'EntrancePermissionController@exportExcel')->middleware(['ability:owner,read-entrance']);
    Route::get('/export/pdf', 'EntrancePermissionController@exportPdf')->middleware(['ability:owner,read-entrance']);
    Route::get('/{id}', 'EntrancePermissionController@show')->middleware(['ability:owner,read-entrance']);
    Route::post('/', 'EntrancePermissionController@store')->middleware(['ability:owner,create-entrance']);
    Route::put('/{id}', 'EntrancePermissionController@update')->middleware(['ability:owner,update-entrance']);
    Route::delete('/', 'EntrancePermissionController@destroyMany')->middleware(['ability:owner,delete-entrance']);
    Route::delete('/{id}', 'EntrancePermissionController@destroy')->middleware(['ability:owner,delete-entrance']);
});
