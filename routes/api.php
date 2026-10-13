<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripDestinationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\AdminController;

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

    // Search country
    Route::get('/countries/search', [CountryController::class, 'search']);

    // Search place
    Route::get('/places/search', [PlaceController::class, 'search']);

    // create trip destination
    Route::post('/trip-destinations', [TripDestinationController::class, 'store']);

    // create destination
    Route::post('/destinations', [DestinationController::class, 'store']);

    // create trip
    Route::post('/trips', [TripController::class, 'store']);

    // show trip
    Route::get('/trips/{id}', [TripController::class, 'show']);

    // update trip
    Route::put('/trips/{id}', [TripController::class, 'update']);

    // delete trip
    Route::delete('/trips/{id}', [TripController::class, 'destroy']);

    // Get all trips for the authenticated user with their destinations
    Route::get('/user/trips', [TripController::class, 'getUserTripsWithDestinations']);

    // all places
    Route::get('/places', [PlaceController::class, 'index']);

    // places by country
    Route::get('/countries/{countryId}/places', [PlaceController::class, 'getPlacesByCountry']);

    // all destinations
    Route::get('/destinations', [DestinationController::class, 'index']);

    // one destination
    Route::get('/destinations/{id}', [DestinationController::class, 'show']);

    // update destination
    Route::put('/destinations/{id}', [DestinationController::class, 'update']);

});

// Administrācijas panelis — tikai lomai "admin"
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    // Users
    Route::get('/users', [AdminController::class, 'users']);
    Route::put('/users/{id}/role', [AdminController::class, 'updateUserRole']);
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser']);

    // Destinations
    Route::get('/destinations', [AdminController::class, 'destinations']);
    Route::put('/destinations/{id}', [AdminController::class, 'updateDestination']);
    Route::put('/destinations/{id}/recommend', [AdminController::class, 'recommendDestination']);
    Route::delete('/destinations/{id}', [AdminController::class, 'destroyDestination']);
});
