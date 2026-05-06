<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\FlightController;

Route::get('/passengers', [PassengerController::class, 'index']);
Route::get('/flights', [FlightController::class, 'index']);
Route::get('/flights/{id}/passengers', [FlightController::class, 'passengers']);