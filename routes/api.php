<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ObservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route to retrieve the authenticated user's details
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes for authentication
Route::post('/auth/register', [AuthController::class, 'register']); // Register a new user
Route::post('/auth/login', [AuthController::class, 'login']); // Log in a user

// Route to get observations (without authentication)
Route::get('/auth/observations', [ObservationController::class, 'index']);

// Routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/user', [AuthController::class, 'user']); // Get authenticated user's details
    Route::get('/auth/logout', [AuthController::class, 'logout']); // Log out user

    Route::get('/auth/observations/user', [ObservationController::class, 'indexByUser']); // Get observations by user

    Route::get('/auth/observations/{uuid}', [ObservationController::class, 'showByUUID']); // Show a specific observation by UUID
    Route::delete('/auth/observations/{uuid}', [ObservationController::class, 'destroyByUUID']); // Delete an observation by UUID
    Route::put('/auth/observations/{uuid}', [ObservationController::class, 'updateByUUID']); // Update an observation by UUID
    Route::get('/auth/observations/body/{id}', [ObservationController::class, 'indexByBodyAndUser']); // Get observations by body and user
    Route::post('/auth/observations', [ObservationController::class, 'store']); // Store a new observation

});
