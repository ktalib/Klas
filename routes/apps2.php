<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GisDataController;
use App\Http\Controllers\AttributionController;
use App\Http\Controllers\SurveyCadastralAttributionController;
use App\Http\Controllers\SurveyAttributionController;
use App\Http\Controllers\GisController;
use App\Http\Controllers\PlanningRecommendationController;
use App\Http\Controllers\SubPlanningRecommendationController;
// Public routes
Route::get('/custom-public', function () {
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
    
    
    Route::prefix('gis_record')->name('gis_record.')->group(function () {
        Route::get('/', [GisController::class, 'index'])->name('index');
        Route::get('/create', [GisController::class, 'create'])->name('create');
        Route::post('/store', [GisController::class, 'store'])->name('store');

        // Add this new route for fetching unit file numbers
        Route::get('/get-units', [GisController::class, 'getUnits'])->name('get-units');

        // Important: This specific route must come BEFORE the wildcard {id} route
        Route::get('/search-files', [GisController::class, 'searchFiles'])->name('search-files');
        // Wildcard routes should come after more specific routes
        Route::get('/{id}', [GisController::class, 'show'])->name('view');
        Route::get('/{id}/edit', [GisController::class, 'edit'])->name('edit');
        Route::put('/{id}', [GisController::class, 'update'])->name('update');
        Route::delete('/{id}', [GisController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('attribution')->group(function () {
        // Routes for AttributionController
        Route::get('/', [AttributionController::class, 'Attributions'])->name('attribution.index');
        Route::get('/create', [AttributionController::class, 'create'])->name('attribution.create');
        Route::post('/store', [AttributionController::class, 'store'])->name('attribution.store');
        Route::get('/update-survey/{id}', [AttributionController::class, 'editSurvey'])->name('attribution.update-survey');
        Route::post('/update-survey', [AttributionController::class, 'updateSurvey'])->name('attribution.update-survey');
        Route::post('/search-fileno', [AttributionController::class, 'searchFileNo'])->name('attribution.search-fileno');

        // New routes for Primary Survey selection
        Route::post('/fetch-primary-surveys', [AttributionController::class, 'fetchPrimarySurveys'])->name('attribution.fetch-primary-surveys');
        Route::get('/primary-survey-details/{id}', [AttributionController::class, 'getPrimarySurveyDetails'])->name('attribution.primary-survey-details');
    });

    Route::prefix('survey_cadastral')->group(function () {
        // Routes for SurveyCadastralAttributionController
        Route::get('/', [SurveyCadastralAttributionController::class, 'Attributions'])->name('survey_cadastral.index');
        Route::get('/create', [SurveyCadastralAttributionController::class, 'create'])->name('survey_cadastral.create');
        Route::post('/store', [SurveyCadastralAttributionController::class, 'store'])->name('survey_cadastral.store');
        Route::get('/update-survey/{id}', [SurveyCadastralAttributionController::class, 'editSurvey'])->name('survey_cadastral.update-survey');
        Route::post('/update-survey', [SurveyCadastralAttributionController::class, 'updateSurvey'])->name('survey_cadastral.update-survey');
        Route::post('/search-fileno', [SurveyCadastralAttributionController::class, 'searchFileNo'])->name('survey_cadastral.search-fileno');

        // New routes for Primary Survey selection
        Route::post('/fetch-primary-surveys', [SurveyCadastralAttributionController::class, 'fetchPrimarySurveys'])->name('survey_cadastral.fetch-primary-surveys');
        Route::get('/primary-survey-details/{id}', [SurveyCadastralAttributionController::class, 'getPrimarySurveyDetails'])->name('survey_cadastral.primary-survey-details');
    });  
    
    Route::prefix('survey_record')->group(function () {
        // Routes for SurveyAttributionController
        Route::get('/', [SurveyAttributionController::class, 'Attributions'])->name('survey_record.index');
        Route::get('/create', [SurveyAttributionController::class, 'create'])->name('survey_record.create');
        Route::post('/store', [SurveyAttributionController::class, 'store'])->name('survey_record.store');
        Route::get('/update-survey/{id}', [SurveyAttributionController::class, 'editSurvey'])->name('survey_record.update-survey');
        Route::post('/update-survey', [SurveyAttributionController::class, 'updateSurvey'])->name('survey_record.update-survey');
        Route::post('/search-fileno', [SurveyAttributionController::class, 'searchFileNo'])->name('survey_record.search-fileno');

        // New routes for Primary Survey selection
        Route::post('/fetch-primary-surveys', [SurveyAttributionController::class, 'fetchPrimarySurveys'])->name('survey_record.fetch-primary-surveys');
        Route::get('/primary-survey-details/{id}', [SurveyAttributionController::class, 'getPrimarySurveyDetails'])->name('survey_record.primary-survey-details');
    });
    

    Route::prefix('pr_memos')->group(function () {
        // Routes for PlanningRecommendation memo
        Route::get('/approval', [PlanningRecommendationController::class, 'ApprovalMome'])->name('pr_memos.approval');
        Route::post('/store', [PlanningRecommendationController::class, 'ApprovalMomeSave'])->name('pr_memos.store'); 
        Route::post('/save-observations', [PlanningRecommendationController::class, 'saveAdditionalObservations'])->name('pr_memos.save-observations');
        
        Route::get('/declination', [PlanningRecommendationController::class, 'Declination'])->name('pr_memos.declination');
        Route::post('/declination/store', [PlanningRecommendationController::class, 'DeclinationSave'])->name('pr_memos.declination.store');
    });  
    
    
    Route::prefix('sub_pr_memos')->group(function () {
        // Routes for SubPlanningRecommendation memo
        Route::get('/approval', [SubPlanningRecommendationController::class, 'ApprovalMome'])->name('sub_pr_memos.approval');
        Route::post('/store', [SubPlanningRecommendationController::class, 'ApprovalMomeSave'])->name('sub_pr_memos.store'); 
        Route::post('/save-observations', [SubPlanningRecommendationController::class, 'saveAdditionalObservations'])->name('sub_pr_memos.save-observations');
        
        Route::get('/declination', [SubPlanningRecommendationController::class, 'Declination'])->name('sub_pr_memos.declination');
        Route::post('/declination/store', [SubPlanningRecommendationController::class, 'DeclinationSave'])->name('sub_pr_memos.declination.store');
    });

});
