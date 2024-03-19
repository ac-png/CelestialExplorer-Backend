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
Route::post('/register', [AuthController::class, 'register']); // Register a new user
Route::post('/login', [AuthController::class, 'login']); // Log in a user

// Route to get observations (without authentication)
Route::get('/observations', [ObservationController::class, 'index']);

// Routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']); // Get authenticated user's details
    Route::get('/logout', [AuthController::class, 'logout']); // Log out user

    Route::get('/dashboard/observations/user', [ObservationController::class, 'indexByUser']); // Get observations by user

    Route::get('/dashboard/observations/{uuid}', [ObservationController::class, 'showByUUID']); // Show a specific observation by UUID
    Route::delete('/dashboard/observations/{uuid}', [ObservationController::class, 'destroyByUUID']); // Delete an observation by UUID
    Route::put('/dashboard/observations/{uuid}', [ObservationController::class, 'updateByUUID']); // Update an observation by UUID
    Route::get('/dashboard/observations/body/{id}', [ObservationController::class, 'indexByBodyAndUser']); // Get observations by body and user
    Route::post('/dashboard/observations', [ObservationController::class, 'store']); // Store a new observation

});
