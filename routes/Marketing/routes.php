<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Marketing\RateController;
use App\Http\Controllers\Marketing\PromoController;
use App\Http\Controllers\Marketing\BookingController;

// Marketing domain routes (Rates, Promos, Bookings)
Route::middleware('jwt.auth')->prefix('marketing')->group(function () {

    // Rates CRUD
    // Route::prefix('rates')->group(function () {
    //     Route::get('/', [RateController::class, 'index']);
    //     Route::get('/{rate}', [RateController::class, 'show']);
    //     Route::post('/', [RateController::class, 'store'])->middleware('permission:create rates');
    //     Route::put('/{rate}', [RateController::class, 'update'])->middleware('permission:edit rates');
    //     Route::delete('/{rate}', [RateController::class, 'destroy'])->middleware('permission:delete rates');
    // });

    Route::prefix('rates')->group(function () {
        Route::get('/', [RateController::class, 'index']);
        Route::get('/{rate}', [RateController::class, 'show']);
        Route::post('/', [RateController::class, 'store']);
        Route::put('/{rate}', [RateController::class, 'update']);
        Route::delete('/{rate}', [RateController::class, 'destroy']);
    });

    // // Promotions CRUD
    // Route::prefix('promos')->group(function () {
    //     Route::get('/', [PromoController::class, 'index']);
    //     Route::get('/{promo}', [PromoController::class, 'show']);
    //     Route::post('/', [PromoController::class, 'store'])->middleware('permission:create promos');
    //     Route::put('/{promo}', [PromoController::class, 'update'])->middleware('permission:edit promos');
    //     Route::delete('/{promo}', [PromoController::class, 'destroy'])->middleware('permission:delete promos');
    // });

    // // Bookings CRUD
    // Route::prefix('bookings')->group(function () {
    //     Route::get('/', [BookingController::class, 'index']);
    //     Route::get('/{booking}', [BookingController::class, 'show']);
    //     Route::post('/', [BookingController::class, 'store'])->middleware('permission:create bookings');
    //     Route::put('/{booking}', [BookingController::class, 'update'])->middleware('permission:edit bookings');
    //     Route::delete('/{booking}', [BookingController::class, 'destroy'])->middleware('permission:delete bookings');
    // });

});
