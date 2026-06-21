<?php

use App\Http\Controllers\Api\CasesController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\ReviewsController;
use App\Http\Controllers\Api\ApplicationsController;
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
Route::post('reviews', [ReviewsController::class, 'store']);

Route::post('applications', [ApplicationsController::class, 'store']);
