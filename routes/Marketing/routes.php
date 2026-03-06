<?php

use App\Http\Controllers\Marketing\AccommodationRateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Marketing\PromoController;
use App\Http\Controllers\Marketing\BookingController;
use App\Http\Controllers\Marketing\InstitutionalAccountController;
use App\Http\Controllers\Marketing\DiscountController;
use App\Http\Controllers\Marketing\AddOnController;
use App\Http\Controllers\Marketing\VehicleRateController;
use App\Http\Controllers\Marketing\IADiscountController;

// Marketing domain routes (Rates, Promos, Bookings, Institutional Accounts)
Route::middleware('jwt.auth')->group(function () {

    // Vehicle Rates CRUD

    Route::prefix('vehicle-rates')->group(function () {
        Route::get('/', [VehicleRateController::class, 'index']);
        Route::get('/{vehicleRateId}', [VehicleRateController::class, 'show']);
        Route::get('/route/{routeId}', [VehicleRateController::class, 'showRoute']);
        Route::post('/', [VehicleRateController::class, 'store']);
        Route::put('/{vehicleRateId}', [VehicleRateController::class, 'update']);
        Route::delete('/{vehicleRateId}', [VehicleRateController::class, 'destroy']);

    //     // Route::get('/', [VehicleRateController::class, 'index'])->middleware('permission:vehicle rate management read');
    //     // Route::get('/{vehicleRateId}', [VehicleRateController::class, 'show'])->middleware('permission:vehicle rate management read');
    //     // Route::post('/', [VehicleRateController::class, 'store'])->middleware('permission:vehicle rate management create');
    //     // Route::put('/{vehicleRateId}', [VehicleRateController::class, 'update'])->middleware('permission:vehicle rate management update');
    //     // Route::delete('/{vehicleRateId}', [VehicleRateController::class, 'destroy'])->middleware('permission:vehicle rate management delete');
    });

    // Accommodation Rates CRUD 

    Route::prefix('accommodation-rates')->group(function () {
        Route::get('/', [AccommodationRateController::class, 'index']);
        Route::get('/{accRateId}', [AccommodationRateController::class, 'show']);
        Route::get('/route/{routeId}', [AccommodationRateController::class, 'showRoute']);
        Route::post('/', [AccommodationRateController::class, 'store']);
        Route::put('/{accRateId}', [AccommodationRateController::class, 'update']);
        Route::delete('/{accRateId}', [AccommodationRateController::class, 'destroy']);

    //     // Route::get('/', [AccommodationRateController::class, 'index'])->middleware('permission:accommodation rate management read');
    //     // Route::get('/{accRateId}', [AccommodationRateController::class, 'show'])->middleware('permission:accommodation rate management read');
    //     // Route::post('/', [AccommodationRateController::class, 'store'])->middleware('permission:accommodation rate management create');
    //     // Route::put('/{accRateId}', [AccommodationRateController::class, 'update'])->middleware('permission:accommodation rate management update');
    //     // Route::delete('/{accRateId}', [AccommodationRateController::class, 'destroy'])->middleware('permission:accommodation rate management delete');
    });


    // Add Ons CRUD 

    Route::prefix('add-ons')->group(function () {
        Route::get('/', [AddOnController::class, 'index']);
        Route::get('/{addOn}', [AddOnController::class, 'show']);
        Route::post('/', [AddOnController::class, 'store']);
        Route::put('/{addOn}', [AddOnController::class, 'update']);
        Route::delete('/{addOn}', [AddOnController::class, 'destroy']);
    });


    // // Promotions CRUD
    // Route::prefix('promos')->group(function () {
    //     Route::get('/', [PromoController::class, 'index']);
    //     Route::get('/{promo}', [PromoController::class, 'show']);
    //     Route::post('/', [PromoController::class, 'store']);
    //     Route::put('/{promo}', [PromoController::class, 'update']);
    //     Route::delete('/{promo}', [PromoController::class, 'destroy']);

    //     // Route::get('/', [PromoController::class, 'index'])->middleware('permission:promo management read');
    //     // Route::get('/{promo}', [PromoController::class, 'show'])->middleware('permission:promo management read');
    //     // Route::post('/', [PromoController::class, 'store'])->middleware('permission:promo management create');
    //     // Route::put('/{promo}', [PromoController::class, 'update'])->middleware('permission:promo management update');
    //     // Route::delete('/{promo}', [PromoController::class, 'destroy'])->middleware('permission:promo management delete');
    // });

    // // Discounts CRUD
    Route::prefix('discount')->group(function () {
        Route::get('/', [DiscountController::class, 'index']);
        Route::get('/{discount}', [DiscountController::class, 'show']);
        Route::post('/', [DiscountController::class, 'store']);
        Route::put('/{discount}', [DiscountController::class, 'update']);
        Route::delete('/{discount}', [DiscountController::class, 'destroy']);

        //     // Route::get('/', [DiscountController::class, 'index'])->middleware('permission:discount management read');
        //     // Route::get('/{discount}', [DiscountController::class, 'show'])->middleware('permission:discount management read');
        //     // Route::post('/', [DiscountController::class, 'store'])->middleware('permission:discount management create');
        //     // Route::put('/{discount}', [DiscountController::class, 'update'])->middleware('permission:discount management update');
        //     // Route::delete('/{discount}', [DiscountController::class, 'destroy'])->middleware('permission:discount management delete');
    });


    // Bookings CRUD
    // Route::prefix('bookings')->group(function () {
    //     Route::get('/', [BookingController::class, 'index']);
    //     Route::get('/{booking}', [BookingController::class, 'show']);
    //     Route::post('/', [BookingController::class, 'store']);
    //     Route::put('/{booking}', [BookingController::class, 'update']);
    //     Route::delete('/{booking}', [BookingController::class, 'destroy']);

    //     // Route::get('/', [BookingController::class, 'index'])->middleware('permission:booking management read');
    //     // Route::get('/{booking}', [BookingController::class, 'show'])->middleware('permission:booking management read');
    //     // Route::post('/', [BookingController::class, 'store'])->middleware('permission:booking management create');
    //     // Route::put('/{booking}', [BookingController::class, 'update'])->middleware('permission:booking management update');
    //     // Route::delete('/{booking}', [BookingController::class, 'destroy'])->middleware('permission:booking management delete');
    // });

    // Institutional Accounts CRUD
  Route::prefix('institutional-accounts')->group(function () {

    Route::prefix('discounts')->group(function () {
        Route::get('/{iaId}', [IADiscountController::class, 'index']);
        Route::post('/', [IADiscountController::class, 'store']);
    });

    Route::get('/', [InstitutionalAccountController::class, 'index']);
    Route::get('/{iaId}', [InstitutionalAccountController::class, 'show']);
    Route::post('/', [InstitutionalAccountController::class, 'store']);
    Route::put('/{iaId}', [InstitutionalAccountController::class, 'update']);
    Route::post('/{iaId}/reset-password', [InstitutionalAccountController::class, 'reset']);

    

    //     // Route::get('/', [InstitutionalAccountController::class, 'index'])->middleware('permission:institutional account management read');
    //     // Route::get('/{institutionalAccount}', [InstitutionalAccountController::class, 'show'])->middleware('permission:institutional account management read');
    //     // Route::post('/', [InstitutionalAccountController::class, 'store'])->middleware('permission:institutional account management create');
    //     // Route::put('/{institutionalAccount}', [InstitutionalAccountController::class, 'update'])->middleware('permission:institutional account management update');
    //     // Route::delete('/{institutionalAccount}', [InstitutionalAccountController::class, 'destroy'])->middleware('permission:institutional account management delete');

});

    


});