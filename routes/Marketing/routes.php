<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Marketing\RateController;
use App\Http\Controllers\Marketing\PromoController;
use App\Http\Controllers\Marketing\BookingController;
use App\Http\Controllers\Marketing\InstitutionalAccountController; // ✅ Add this line

// Marketing domain routes (Rates, Promos, Bookings, Institutional Accounts)
Route::middleware('jwt.auth')->prefix('marketing')->group(function () {

    // Rates CRUD
    Route::prefix('rates')->group(function () {
        Route::get('/', [RateController::class, 'index']);
        Route::get('/{rate}', [RateController::class, 'show']);
        Route::post('/', [RateController::class, 'store']);
        Route::put('/{rate}', [RateController::class, 'update']);
        Route::delete('/{rate}', [RateController::class, 'destroy']);

        // Route::get('/', [RateController::class, 'index'])->middleware('permission:rate management read');
        // Route::get('/{rate}', [RateController::class, 'show'])->middleware('permission:rate management read');
        // Route::post('/', [RateController::class, 'store'])->middleware('permission:rate management create');
        // Route::put('/{rate}', [RateController::class, 'update'])->middleware('permission:rate management update');
        // Route::delete('/{rate}', [RateController::class, 'destroy'])->middleware('permission:rate management delete');
    });

    // Promotions CRUD
    Route::prefix('promos')->group(function () {
        Route::get('/', [PromoController::class, 'index']);
        Route::get('/{promo}', [PromoController::class, 'show']);
        Route::post('/', [PromoController::class, 'store']);
        Route::put('/{promo}', [PromoController::class, 'update']);
        Route::delete('/{promo}', [PromoController::class, 'destroy']);

        // Route::get('/', [PromoController::class, 'index'])->middleware('permission:promo management read');
        // Route::get('/{promo}', [PromoController::class, 'show'])->middleware('permission:promo management read');
        // Route::post('/', [PromoController::class, 'store'])->middleware('permission:promo management create');
        // Route::put('/{promo}', [PromoController::class, 'update'])->middleware('permission:promo management update');
        // Route::delete('/{promo}', [PromoController::class, 'destroy'])->middleware('permission:promo management delete');
    });

    // Bookings CRUD
    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingController::class, 'index']);
        Route::get('/{booking}', [BookingController::class, 'show']);
        Route::post('/', [BookingController::class, 'store']);
        Route::put('/{booking}', [BookingController::class, 'update']);
        Route::delete('/{booking}', [BookingController::class, 'destroy']);

        // Route::get('/', [BookingController::class, 'index'])->middleware('permission:booking management read');
        // Route::get('/{booking}', [BookingController::class, 'show'])->middleware('permission:booking management read');
        // Route::post('/', [BookingController::class, 'store'])->middleware('permission:booking management create');
        // Route::put('/{booking}', [BookingController::class, 'update'])->middleware('permission:booking management update');
        // Route::delete('/{booking}', [BookingController::class, 'destroy'])->middleware('permission:booking management delete');
    });

    // Institutional Accounts CRUD
    Route::prefix('institutional-accounts')->group(function () {
        Route::get('/', [InstitutionalAccountController::class, 'index']);
        Route::get('/{institutionalAccount}', [InstitutionalAccountController::class, 'show']);
        Route::post('/', [InstitutionalAccountController::class, 'store']);
        Route::put('/{institutionalAccount}', [InstitutionalAccountController::class, 'update']);
        Route::delete('/{institutionalAccount}', [InstitutionalAccountController::class, 'destroy']);

        // Route::get('/', [InstitutionalAccountController::class, 'index'])->middleware('permission:institutional account management read');
        // Route::get('/{institutionalAccount}', [InstitutionalAccountController::class, 'show'])->middleware('permission:institutional account management read');
        // Route::post('/', [InstitutionalAccountController::class, 'store'])->middleware('permission:institutional account management create');
        // Route::put('/{institutionalAccount}', [InstitutionalAccountController::class, 'update'])->middleware('permission:institutional account management update');
        // Route::delete('/{institutionalAccount}', [InstitutionalAccountController::class, 'destroy'])->middleware('permission:institutional account management delete');
    });

});
