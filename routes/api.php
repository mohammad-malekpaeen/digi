<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OtpController;
use App\Http\Controllers\API\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('send-otp', [OtpController::class, 'sendOtp']);
    Route::post('forget', [OtpController::class, 'forget']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'operations', 'as' => 'operations.', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('posts', PostController::class)->only('store,update');
    Route::post('search', [PostController::class, 'search']);
    Route::apiResource('categories', PostController::class)->only('store,update');
});
