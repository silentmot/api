<?php

Route::prefix('v1/mob')->group(function () {
    Route::get('otp', 'SupervisorController@otp');

    Route::prefix('auth')->group(function () {
        Route::post('phone', 'LoginController@generateOTP');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@revokeToken')->middleware(['auth:supervisor']);
    });

    Route::prefix('inspector')->middleware(['auth:api', 'inspector.use-mobile'])->group(function () {
        Route::prefix('tickets')->group(function () {
            Route::get('/', 'InspectorController@listTickets');
            Route::get('/{id}', 'TicketController@show');
            Route::post('/', 'TicketController@store');
            Route::post('/{id}/images', 'TicketController@storeImage');
            Route::patch('/{id}/status', 'TicketController@updateStatus');
        });
    });

    Route::prefix('supervisor')->middleware(['auth:supervisor', 'supervisor.status'])->group(function () {
        Route::prefix('tickets')->middleware(['supervisor.headers'])->group(function () {
            Route::get('/', 'SupervisorController@listTickets');
            Route::get('/{id}', 'TicketController@show');
            Route::post('/{id}/response', 'TicketController@respond');
            Route::post('/{id}/images', 'TicketController@storeImage');
        });
        Route::get('/profile', 'SupervisorController@showProfile');
        Route::get('active-contracts', 'ContractsController@activeList');
    });

    Route::prefix('admin')->middleware(['auth:api'])->group(function () {
        Route::prefix('tickets')->group(function () {
            Route::get('/', 'AdminController@listTickets')->middleware(['ability:owner,read-inspector']);
            Route::get('/{id}', 'TicketController@show')->middleware(['ability:owner,read-inspector']);
            Route::post('/{id}/response', 'TicketController@respond')->middleware(['ability:owner,update-inspector']);
            Route::patch('/{id}/status', 'TicketController@updateStatus')->middleware(['ability:owner,update-inspector']);
        });
    });
});
