<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployerRequestController;
use App\Http\Controllers\Api\ExpertController;
use App\Http\Controllers\Api\ProgramController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Praktix API Routes
|--------------------------------------------------------------------------
|
| Public routes: programs (read), experts (read), apply, employer requests
| Protected routes: all write operations, admin management
|
*/

// ─── Health Check ────────────────────────────────────────────────────────────
Route::get('/health', fn () => response()->json([
    'status'  => 'ok',
    'service' => 'Praktix API',
    'version' => '1.0.0',
]));

// ─── Auth ─────────────────────────────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

// ─── Public Routes ────────────────────────────────────────────────────────────
// Programs (read-only)
Route::get('/programs', [ProgramController::class, 'index']);
Route::get('/programs/{program}', [ProgramController::class, 'show']);

// Experts (read-only)
Route::get('/experts', [ExpertController::class, 'index']);
Route::get('/experts/{expert}', [ExpertController::class, 'show']);

// Student applications (submit)
Route::post('/applications', [ApplicationController::class, 'store']);

// Employer requests (submit)
Route::post('/employer-requests', [EmployerRequestController::class, 'store']);

// ─── Protected Admin Routes ───────────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Programs management
    Route::post('/programs', [ProgramController::class, 'store']);
    Route::put('/programs/{program}', [ProgramController::class, 'update']);
    Route::delete('/programs/{program}', [ProgramController::class, 'destroy']);

    // Experts management
    Route::post('/experts', [ExpertController::class, 'store']);
    Route::put('/experts/{expert}', [ExpertController::class, 'update']);
    Route::delete('/experts/{expert}', [ExpertController::class, 'destroy']);

    // Applications management
    Route::get('/applications', [ApplicationController::class, 'index']);
    Route::get('/applications/{application}', [ApplicationController::class, 'show']);
    Route::patch('/applications/{application}/status', [ApplicationController::class, 'updateStatus']);
    Route::delete('/applications/{application}', [ApplicationController::class, 'destroy']);

    // Employer requests management
    Route::get('/employer-requests', [EmployerRequestController::class, 'index']);
    Route::get('/employer-requests/{employerRequest}', [EmployerRequestController::class, 'show']);
    Route::patch('/employer-requests/{employerRequest}/status', [EmployerRequestController::class, 'updateStatus']);
    Route::delete('/employer-requests/{employerRequest}', [EmployerRequestController::class, 'destroy']);
});
