<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkoutSessionController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {                                                                                 
    Route::get('/auth/me', [AuthController::class, 'me']);                                                                             
    Route::post('/auth/logout', [AuthController::class, 'logout']);                                                                    
    Route::get('/workout-sessions', [WorkoutSessionController::class, 'index']);                                                              
});   
