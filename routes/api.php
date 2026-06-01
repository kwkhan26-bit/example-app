<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\AuthController;

// Public routes (no login needed)
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (need token)
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Flights (any logged in user can view)
    Route::get('/flights', [FlightController::class, 'index']);

    // Passengers - anyone logged in can VIEW
    Route::get('/passengers',              [PassengerController::class, 'index']);
    Route::get('/passengers/{passenger}',  [PassengerController::class, 'show']);

    // Passengers - only ADMIN can create, update, delete
    Route::middleware('role:admin')->group(function () {
        Route::post('/passengers',                [PassengerController::class, 'store']);
        Route::put('/passengers/{passenger}',     [PassengerController::class, 'update']);
        Route::delete('/passengers/{passenger}',  [PassengerController::class, 'destroy']);
    });

});