<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', LoginController::class)->middleware('guest');
    Route::post('/logout', LogoutController::class)->middleware('auth');
    Route::post('/register', RegisterController::class)->middleware('guest');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
