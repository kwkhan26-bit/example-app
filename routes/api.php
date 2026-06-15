<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\AuthController;

// Rate limiter for login
RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});

// Public routes
Route::middleware('throttle:login')->post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // View only for all logged in users
    Route::apiResource('flights', FlightController::class)->only(['index', 'show']);
    Route::apiResource('passengers', PassengerController::class)->only(['index', 'show']);

    // Assign/unassign passenger to flight
    Route::post('/flights/{flight}/assign', [FlightController::class, 'assign']);
    Route::delete('/flights/{flight}/unassign', [FlightController::class, 'unassign']);

    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('flights', FlightController::class)->except(['index', 'show']);
        Route::apiResource('passengers', PassengerController::class)->except(['index', 'show']);
    });

});