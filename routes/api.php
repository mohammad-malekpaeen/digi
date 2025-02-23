<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OtpController;
use App\Http\Controllers\API\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('send-otp', [OtpController::class, 'sendOtp']);
    Route::post('forget', [OtpController::class, 'forget']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'product', 'as' => 'product.', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('create', [ProductController::class, 'store']);
    Route::post('add-images', [ProductController::class, 'addImage']);
    Route::post('order/submit', [ProductController::class, 'orderSubmit']);
    Route::get('remove/{id}', [ProductController::class, 'remove']);
});
