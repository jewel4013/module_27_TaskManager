<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\PasswordController;
use App\Http\Controllers\Api\V1\GroupController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);

        Route::post('forgot-password', [PasswordController::class, 'forgotPasswordOtpSend']);
        Route::post('forgot-password/verify', [PasswordController::class, 'forgotPasswordVerify']);
        Route::post('reset-password', [PasswordController::class, 'resetPassword']);

        Route::group(['middleware' => 'auth:sanctum'], function (){
            Route::get('user', [UserController::class, 'profile']);
            Route::put('user/profile', [UserController::class, 'updateProfile']);
            Route::post('user/logout', [UserController::class, 'logout']); // Accept: application/json

        });
    });

    Route::group(['middleware' => 'auth:sanctum'], function (){
        Route::apiResource('groups', GroupController::class);
    });

    Route::group(['middleware' => 'auth:sanctum'], function (){
        Route::apiResource('tasks', TaskController::class);

    });
});





