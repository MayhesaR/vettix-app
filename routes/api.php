<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\VenueApiController;

Route::prefix('events')->group(function () {
    Route::get('/', [EventApiController::class, 'index']);
    Route::get('/{id}', [EventApiController::class, 'show']);
    Route::post('/', [EventApiController::class, 'store']);
    Route::put('/{id}', [EventApiController::class, 'update']);
    Route::delete('/{id}', [EventApiController::class, 'destroy']);
});


Route::prefix('venues')->group(function () {
    Route::get('/', [VenueApiController::class, 'index']);
    Route::get('/{id}', [VenueApiController::class, 'show']);
    Route::post('/', [VenueApiController::class, 'store']);
    Route::put('/{id}', [VenueApiController::class, 'update']);
    Route::delete('/{id}', [VenueApiController::class, 'destroy']);
});
