<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlightAssignmentController;
use App\Http\Controllers\UserController; // <--- Added this

// Public routes
Route::middleware('throttle:login')->post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // View only for all logged in users
    Route::apiResource('flights', FlightController::class)->only(['index', 'show']);
    Route::apiResource('passengers', PassengerController::class)->only(['index', 'show']);

    // Excel Export/Import routes
    Route::get('/users/export', [UserController::class, 'export']);
    Route::post('/users/import', [UserController::class, 'import']);

    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('flights', FlightController::class)->except(['index', 'show']);
        Route::apiResource('passengers', PassengerController::class)->except(['index', 'show']);
        Route::post('/passengers/{passenger}/image', [PassengerController::class, 'uploadImage']);
        
        // Assign/unassign passenger to flight
        Route::post('/flights/{flight}/assign', [FlightAssignmentController::class, 'assign']);
        Route::delete('/flights/{flight}/unassign', [FlightAssignmentController::class, 'unassign']);
    });

});