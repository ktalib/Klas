<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GisDataController;
use App\Http\Controllers\AttributionController;
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
        
        // Add this new route for fetching unit file numbers
        Route::get('/get-units', [GisDataController::class, 'getUnits'])->name('get-units');
        
        // Important: This specific route must come BEFORE the wildcard {id} route
        Route::get('/search-files', [GisDataController::class, 'searchFiles'])->name('search-files');
        // Wildcard routes should come after more specific routes
        Route::get('/{id}', [GisDataController::class, 'show'])->name('view');
        Route::get('/{id}/edit', [GisDataController::class, 'edit'])->name('edit');
        Route::put('/{id}', [GisDataController::class, 'update'])->name('update');
        Route::delete('/{id}', [GisDataController::class, 'destroy'])->name('destroy');
    });
    
    Route::prefix('attribution')->group(function () {
        // Routes for AttributionController
        Route::get('/', [AttributionController::class, 'Attributions'])->name('attribution.index');
        Route::get('/create', [AttributionController::class, 'create'])->name('attribution.create');
        Route::post('/store', [AttributionController::class, 'store'])->name('attribution.store');
        Route::get('/update-survey/{id}', [AttributionController::class, 'editSurvey'])->name('attribution.update-survey');
        Route::post('/update-survey', [AttributionController::class, 'updateSurvey'])->name('attribution.update-survey');
        Route::post('/search-fileno', [AttributionController::class, 'searchFileNo'])->name('attribution.search-fileno');
    });
});

