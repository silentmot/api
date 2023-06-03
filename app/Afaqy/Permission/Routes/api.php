<?php

Route::prefix('v1/permissions')->middleware(['auth:api'])->group(function () {
//    Old report calculation
//    Route::get('/', 'PermissionController@index')->middleware(['ability:owner,read-permission']);
    Route::get('/', 'PermissionController@logs')->middleware(['ability:owner,read-permission']);
    Route::get('/types', 'PermissionController@types')->middleware(['ability:owner,read-permission|read-dashboard']);
    Route::get('/export/excel', 'PermissionController@exportExcel')->middleware(['ability:owner,read-permission']);
    Route::get('/export/pdf', 'PermissionController@exportPdf')->middleware(['ability:owner,read-permission']);
    Route::get('/{type}/serials', 'PermissionController@permissionSerials')
        ->where(['type' => '[a-z]+'])
        ->middleware(['ability:owner,read-permission']);

    Route::post('/{type}/append-units/{number}', 'PermissionController@appendUnits')
        ->where(['type' => '[a-z]+', 'number' => '[0-9]+'])
        ->middleware(['ability:owner,create-permission']);

    Route::get('/{type}/{id}', 'PermissionController@showPermission')
        ->where(['type' => '[a-z]+', 'id' => '[0-9]+'])
        ->middleware(['ability:owner,read-permission']);
});

Route::prefix('v1/commercial-damaged-permissions')->middleware(['auth:api'])->group(function () {
    Route::get('/details/{number}', 'CommercialPermissionController@getByNumber')->middleware(['ability:owner,read-permission']);
    Route::post('/', 'CommercialPermissionController@store')->middleware(['ability:owner,create-permission']);
});

Route::prefix('v1/governmental-damaged-permissions')->middleware(['auth:api'])->group(function () {
    Route::get('/details/{number}', 'GovernmentalPermissionController@getByNumber')->middleware(['ability:owner,read-permission']);
    Route::post('/', 'GovernmentalPermissionController@store')->middleware(['ability:owner,create-permission']);
});

Route::prefix('v1/individual-permissions')->middleware(['auth:api'])->group(function () {
    Route::get('/details/{number}', 'IndividualPermissionController@getByNumber')->middleware(['ability:owner,read-permission']);
    Route::post('/', 'IndividualPermissionController@store')->middleware(['ability:owner,create-permission']);
});

Route::prefix('v1/damaged-projects-permissions')->middleware(['auth:api'])->group(function () {
    Route::get('/details/{number}', 'ProjectsPermissionController@getByNumber')->middleware(['ability:owner,read-permission']);
    Route::post('/', 'ProjectsPermissionController@store')->middleware(['ability:owner,create-permission']);
});

Route::prefix('v1/sorting-area-permissions')->middleware(['auth:api'])->group(function () {
    Route::post('/', 'SortingPermissionController@store')->middleware(['ability:owner,create-permission']);
});
