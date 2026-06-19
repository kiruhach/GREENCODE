<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->file(public_path('index.html'));
});

Route::get('/debug', function () {
    $sessionId = session()->getId();
    $token = csrf_token();
    $cookies = request()->cookies->all();
    $sessionData = session()->all();

    return response()->json([
        'session_id' => $sessionId,
        'csrf_token' => $token,
        'session_has' => session()->has('_token'),
        'session_data_keys' => array_keys($sessionData),
        'cookies' => $cookies,
    ]);
});
