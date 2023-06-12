<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlockedDayController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {
    Route::get('auth/user', [AuthController::class ,'user'])->middleware('auth:sanctum');
    Route::post('auth/login', [AuthController::class ,'login']);
    Route::post('auth/register', [AuthController::class ,'register']);
    Route::apiResource('/bookings', BookingController::class);
    Route::post('remove/blocked-dates-times', [BlockedDayController::class ,'destroy']);
    Route::get('/remove/block-all-slots/{date}', [BlockedDayController::class ,'destroyAllSlots']);
    Route::apiResource('/blocked-dates-times', BlockedDayController::class)->only(['index', 'store', 'show']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('auth/logout', [AuthController::class ,'logout']);
        Route::apiResource('/users', AuthController::class);
    });
});


