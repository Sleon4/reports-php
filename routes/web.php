<?php

use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use LionRoute\Route;

/**
 * ------------------------------------------------------------------------------
 * Web Routes
 * ------------------------------------------------------------------------------
 * Here is where you can register web routes for your application
 * ------------------------------------------------------------------------------
 **/

Route::any('/', fn() => info(200, "[index]"));

Route::prefix('api', function() {
    Route::get('users', [UsersController::class, 'readUsers']);

    Route::prefix('reports', function() {
        Route::get('spreadsheet', [ReportsController::class, 'spreadsheet']);
        Route::get('pdf', [ReportsController::class, 'pdf']);
    });
});
