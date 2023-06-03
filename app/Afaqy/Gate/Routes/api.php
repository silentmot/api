<?php

Route::prefix('v1/gates')->middleware(['auth:api'])->group(function () {
    Route::get('/', 'GateController@index')->middleware(['ability:owner,read-gate']);
    Route::get('/export', 'GateController@export')->middleware(['ability:owner,read-gate']);
});
