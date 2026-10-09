<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripDestinationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/trip-destinations/recommendations', [TripDestinationController::class, 'recommendations']);
Route::get('/recommendations/search', [TripDestinationController::class, 'searchRecommendations']);
Route::get('/recommendations/category', [ TripDestinationController::class,'filterByCategory']);
Route::get('/recommendations/status', [ TripDestinationController::class,'filterByStatus']);
Route::get('/trip/destinations/{id}', [TripDestinationController::class, 'show']);

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/recommendations/status', [ TripDestinationController::class,'filterByStatus']);
    // Current user
    Route::get('/me', [AuthController::class, 'me']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Profile
    Route::get('/profile', [UserController::class, 'show']);

    // Change email
    Route::put('/profile/email', [UserController::class, 'update']);
   
    // Delete profile
    Route::delete('/profile', [UserController::class, 'destroy']);

    // Change password
    Route::put('/profile/password', [UserController::class, 'changePassword']);
});