<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OtpController;
use App\Http\Controllers\API\PostController;
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
    Route::post('otp', [OtpController::class, 'create']);
    Route::post('forget', [OtpController::class, 'forget']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'middleware' => 'auth:api'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'operations', 'as' => 'operations.', 'middleware' => 'auth:api'], function () {
    Route::apiResource('posts', PostController::class)->only('store,update');
    Route::post('search', [PostController::class, 'search']);
    Route::apiResource('categories', PostController::class)->only('store,update');
});
