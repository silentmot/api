<?php

Route::prefix('v1/cap')->group(function () {
    Route::post('/token', 'AuthController@token');

    Route::middleware(['client:cap', 'locale:en'])->group(function () {
        Route::get('/districts', 'CapDistrictsController@index');
        Route::get('/waste-types', [Afaqy\WasteType\Http\Controllers\WasteTypeController::class, 'index']);
        Route::get('/unit-types', [Afaqy\UnitType\Http\Controllers\UnitTypeController::class, 'index']);

        Route::prefix('/units')->group(function () {
            Route::get('/', [Afaqy\Unit\Http\Controllers\UnitController::class, 'index']);
            Route::get('/{id}', [Afaqy\Unit\Http\Controllers\UnitController::class, 'show']);
            Route::post('/', [Afaqy\Unit\Http\Controllers\UnitController::class, 'store']);
        });

        Route::prefix('/contractors')->group(function () {
            Route::get('/', [Afaqy\Contractor\Http\Controllers\ContractorController::class, 'index']);
            Route::get('/{id}', [Afaqy\Contractor\Http\Controllers\ContractorController::class, 'show']);
            Route::post('/', [Afaqy\Contractor\Http\Controllers\ContractorController::class, 'store']);
        });

        Route::prefix('/contracts')->group(function () {
            Route::get('/', [Afaqy\Contract\Http\Controllers\ContractController::class, 'index']);
            Route::get('/{id}', [Afaqy\Contract\Http\Controllers\ContractController::class, 'show']);
            Route::post('/', [Afaqy\Contract\Http\Controllers\ContractController::class, 'store']);
        });

        Route::prefix('/permissions')->group(function () {
            Route::post('/commercial', [Afaqy\Permission\Http\Controllers\CommercialPermissionController::class, 'store']);
            Route::post('/governmental', [Afaqy\Permission\Http\Controllers\GovernmentalPermissionController::class, 'store']);
            Route::post('/individual', [Afaqy\Permission\Http\Controllers\IndividualPermissionController::class, 'store']);
            Route::post('/projects', [Afaqy\Permission\Http\Controllers\ProjectsPermissionController::class, 'store']);
            Route::post('/sorting', [Afaqy\Permission\Http\Controllers\SortingPermissionController::class, 'store']);

            Route::post('/{type}/append-units/{number}', [Afaqy\Permission\Http\Controllers\PermissionController::class, 'appendUnits'])
                ->where(['type' => '[a-z]+', 'number' => '[0-9]+']);
            Route::put('/{type}/unit/{qr}', [Afaqy\Permission\Http\Controllers\PermissionController::class, 'updatePermissionUnit'])
                ->where(['type' => '[a-z]+', 'qr' => '[0-9]+']);
            Route::delete('/{type}/unit/{qr}', [Afaqy\Permission\Http\Controllers\PermissionController::class, 'deletePermissionUnit'])
                ->where(['type' => '[a-z]+', 'qr' => '[0-9]+']);
        });
    });
});

Route::prefix('v1/masader')->group(function () {
    Route::post('/token', 'AuthController@token');

    Route::middleware(['client:masader', 'locale:en'])->group(function () {
//        Route::get('/transactions', 'MasaderController@transactions');
        Route::get('/load_code/{id}', [Afaqy\WasteType\Http\Controllers\WasteTypeController::class, 'show']);
        Route::get('/company_code/{id}', [Afaqy\Contractor\Http\Controllers\ContractorController::class, 'show']);
    });
});
