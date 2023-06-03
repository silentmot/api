<?php

use Afaqy\Core\Http\Controllers\CoreController;

Route::prefix('v1')->group(function () {
    Route::get('image/{path}/{name}', [CoreController::class, 'generateImage'])->name('image.show');
    Route::get('/debug-sentry', [CoreController::class, 'debug']);
});
