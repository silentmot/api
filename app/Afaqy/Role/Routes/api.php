<?php

Route::prefix('v1/roles')->middleware(['auth:api'])->group(function () {
    Route::get('/', 'RoleController@index')->middleware(['ability:owner,read-role|create-user|update-user']);
    Route::get('/export/excel', 'RoleController@exportExcel')->middleware(['ability:owner,read-role']);
    Route::get('/export/pdf', 'RoleController@exportPdf')->middleware(['ability:owner,read-role']);
    Route::get('/permissions', 'RoleController@permissions')->middleware(['ability:owner,read-role']);
    Route::get('/notifications', 'RoleController @notifications')->middleware(['ability:owner,read-role']);
    Route::get('/{id}', 'RoleController@show')->middleware(['ability:owner,read-role']);
    Route::post('/', 'RoleController@store')->middleware(['ability:owner,create-role']);
    Route::put('/{id}', 'RoleController@update')->middleware(['ability:owner,update-role']);
    Route::delete('/', 'RoleController@destroyMany')->middleware(['ability:owner,delete-role']);
    Route::delete('/{id}', 'RoleController@destroy')->middleware(['ability:owner,delete-role']);
});
