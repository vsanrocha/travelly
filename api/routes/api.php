<?php

use App\Http\Controllers\Api\TravelRequestController;
use App\Http\Controllers\Api\AuthController;

Route::post('/signup', [AuthController::class, 'signUp']);
Route::post('/signin', [AuthController::class, 'signIn']);

Route::middleware('auth:sanctum')->group(function () {
	Route::get('/travel-requests', [TravelRequestController::class, 'index']);
	Route::post('/travel-requests', [TravelRequestController::class, 'store']);
	Route::get('/travel-requests/{travelRequest}', [TravelRequestController::class, 'show']);
	Route::patch('/travel-requests/{travelRequest}/status', [TravelRequestController::class, 'updateStatus']);
});
