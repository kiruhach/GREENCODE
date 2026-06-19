<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CasesController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\ReviewsController;
use App\Http\Controllers\Api\ApplicationsController;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Support\Facades\Route;

// Диагностика
Route::get('ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::get('env-dump', function () {
    return response()->json([
        'env_DB_CONNECTION' => env('DB_CONNECTION'),
        'env_DB_HOST' => env('DB_HOST'),
        'env_DB_PORT' => env('DB_PORT'),
        'env_DB_DATABASE' => env('DB_DATABASE'),
        'env_DB_USERNAME' => env('DB_USERNAME'),
        'getenv_DB_CONNECTION' => getenv('DB_CONNECTION'),
        'getenv_DB_HOST' => getenv('DB_HOST'),
        'getenv_DB_PORT' => getenv('DB_PORT'),
        'getenv_DB_DATABASE' => getenv('DB_DATABASE'),
        'getenv_DB_USERNAME' => getenv('DB_USERNAME'),
        '_ENV_DB_HOST' => $_ENV['DB_HOST'] ?? 'NOT SET',
        '_ENV_DB_PORT' => $_ENV['DB_PORT'] ?? 'NOT SET',
        '_SERVER_DB_HOST' => $_SERVER['DB_HOST'] ?? 'NOT SET',
        '_SERVER_DB_PORT' => $_SERVER['DB_PORT'] ?? 'NOT SET',
        'DATABASE_URL' => env('DATABASE_URL'),
        '_ENV_DATABASE_URL' => $_ENV['DATABASE_URL'] ?? 'NOT SET',
        'APP_ENV' => env('APP_ENV'),
        'APP_KEY_exists' => env('APP_KEY') ? 'YES' : 'NO',
    ]);
});

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
