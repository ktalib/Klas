<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GisDataController;

// Public routes
Route::get('/custom-public', function() {
    return 'This is a public custom route';
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // GIS related routes
    Route::prefix('gis')->name('gis.')->group(function () {
        Route::get('/', [GisDataController::class, 'index'])->name('index');
        Route::get('/create', [GisDataController::class, 'create'])->name('create');
        Route::post('/store', [GisDataController::class, 'store'])->name('store');
        Route::get('/{id}', [GisDataController::class, 'show'])->name('view');
    });
    
    // Add other route groups here
    // Example:
    // Route::prefix('dashboard')->name('dashboard.')->group(function () {
    
    // });
});

