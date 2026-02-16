<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;

Route::post("/test/",[WelcomeController::class,'testApi']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', [\App\Http\Controllers\UsersController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\UsersController::class, 'register']);
    Route::get('/logout', [\App\Http\Controllers\UsersController::class, 'logout'])->middleware('auth:api');
});
