<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripDestinationController;
use Illuminate\Support\Facades\Route;

Route::get('/trip-destinations/recommendations', [TripDestinationController::class, 'recommendations']);
Route::get('/recommendations/search', [TripDestinationController::class,'searchRecommendations']);

Route::middleware('web')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

});