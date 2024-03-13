<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ObservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::get('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/auth/observations/{uuid}', [ObservationController::class, 'showByUUID']);
    Route::delete('/auth/observations/{uuid}', [ObservationController::class, 'destroyByUUID']);
    Route::put('/auth/observations/{uuid}', [ObservationController::class, 'updateByUUID']);
    Route::get('/auth/observations/body/{id}', [ObservationController::class, 'indexByBodyAndUser']);


    Route::apiResource('/auth/observations', ObservationController::class);
});
