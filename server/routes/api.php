<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CasesController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\ReviewsController;
use App\Http\Controllers\Api\ApplicationsController;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Support\Facades\Route;

// Публичные маршруты
Route::get('cases', [CasesController::class, 'index']);
Route::get('cases/{id}', [CasesController::class, 'show']);

Route::get('services', [ServicesController::class, 'index']);
Route::get('services/{id}', [ServicesController::class, 'show']);
Route::get('services/{id}/details', [ServicesController::class, 'details']);
Route::get('services/details/all', [ServicesController::class, 'allDetails']);

Route::get('reviews', [ReviewsController::class, 'index']);
Route::get('reviews/latest', [ReviewsController::class, 'latest']);

Route::post('applications', [ApplicationsController::class, 'store']);

// Аутентификация
Route::post('auth/login', [AuthController::class, 'login']);

// Защищённые маршруты (admin)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/user', [AuthController::class, 'user']);

    Route::post('cases', [CasesController::class, 'store']);
    Route::put('cases/{id}', [CasesController::class, 'update']);
    Route::delete('cases/{id}', [CasesController::class, 'destroy']);

    Route::post('services', [ServicesController::class, 'store']);
    Route::put('services/{id}', [ServicesController::class, 'update']);
    Route::delete('services/{id}', [ServicesController::class, 'destroy']);

    Route::post('reviews', [ReviewsController::class, 'store']);
    Route::put('reviews/{id}', [ReviewsController::class, 'update']);
    Route::delete('reviews/{id}', [ReviewsController::class, 'destroy']);

    Route::get('applications', [ApplicationsController::class, 'index']);
    Route::get('applications/{id}', [ApplicationsController::class, 'show']);
    Route::put('applications/{id}/status', [ApplicationsController::class, 'updateStatus']);
    Route::delete('applications/{id}', [ApplicationsController::class, 'destroy']);

    Route::post('upload', [UploadController::class, 'upload']);
    Route::delete('upload', [UploadController::class, 'delete']);
});
