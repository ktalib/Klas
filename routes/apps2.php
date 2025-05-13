<?php

use Illuminate\Support\Facades\Route;
// Import your controllers here
// Example:
// use App\Http\Controllers\YourNewController;

// Public routes
Route::get('/custom-public', function() {
    return 'This is a public custom route';
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    
 
});
