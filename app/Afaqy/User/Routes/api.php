<?php

Route::prefix('v1')->group(function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('password/reset/{token}/{email}', 'Auth\ResetPasswordController@redirectToFront')->name('password.reset');

    Route::middleware(['auth:api'])->group(function () {
        Route::post('logout', 'Auth\LoginController@forgetToken');

        Route::prefix('users')->group(function () {
            Route::get('/', 'UserController@index')->middleware(['ability:owner,read-user']);
            Route::post('/', 'UserController@store')->middleware(['ability:owner,create-user']);
            Route::delete('/', 'UserController@destroyMany')->middleware(['ability:owner,delete-user']);
            Route::get('/export/excel', 'UserController@exportExcel')->middleware(['ability:owner,read-user']);
            Route::get('/export/pdf', 'UserController@exportPdf')->middleware(['ability:owner,read-user']);
            Route::get('/profile', 'UserController@showProfile');
            Route::put('/profile', 'UserController@updateProfile');
            Route::get('/permissions', 'UserController@getPermissions');
            Route::get('/{id}', 'UserController@show')->middleware(['ability:owner,read-user']);
            Route::put('/{id}', 'UserController@update')->middleware(['ability:owner,update-user']);
            Route::delete('/{id}', 'UserController@destroy')->middleware(['ability:owner,delete-user']);
        });
    });
});
