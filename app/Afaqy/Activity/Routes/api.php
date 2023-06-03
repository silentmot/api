<?php

Route::prefix('v1/activities')->middleware(['auth:api', 'ability:owner,read-dashboard'])->group(function () {
    Route::get('/', 'ActivityController@index');
    Route::get('/{id}', 'ActivityController@show');
});
