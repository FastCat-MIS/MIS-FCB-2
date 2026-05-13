<?php

use App\Http\Controllers\Teller\BookedPassengerController;
use App\Http\Controllers\Teller\BookedVehicleController;
use App\Http\Controllers\Teller\PaymentController;
use Illuminate\Support\Facades\Route;

// Generate share token without authentication
Route::get('/teller-booking/share-token', function () {
    return app(\App\Actions\Teller\GenerateShareTokenAction::class)->execute();
});

Route::middleware('pem.jwt:payment.read')->group(function () {
    Route::prefix('teller-booking')->group(function () {
    Route::get('/book-passenger', [BookedPassengerController::class, 'index']);
    Route::get('/book-passenger/{bookedPassengerId}', [BookedPassengerController::class, 'show']);
    Route::post('/book-passenger', [BookedPassengerController::class, 'store']);
    Route::patch('/book-passenger/{bookedPassengerId}', [BookedPassengerController::class, 'update']);
    Route::delete('/book-passenger/{bookedPassengerId}', [BookedPassengerController::class, 'destroy']);

    Route::get('/book-vehicle', [BookedVehicleController::class, 'index']);
    Route::get('/book-vehicle/{bookedVehicleId}', [BookedVehicleController::class, 'show']);
    Route::post('/book-vehicle', [BookedVehicleController::class, 'store']);
    Route::patch('/book-vehicle/{bookedVehicleId}', [BookedVehicleController::class, 'update']);
    Route::delete('/book-vehicle/{bookedVehicleId}', [BookedVehicleController::class, 'destroy']);

    Route::get('/payment', [PaymentController::class, 'index']);
    Route::get('/payment/{paymentId}', [PaymentController::class, 'show']);
    Route::post('/payment', [PaymentController::class, 'store']);
    Route::patch('/payment/{paymentId}', [PaymentController::class, 'update']);
    Route::delete('/payment/{paymentId}', [PaymentController::class, 'destroy']);
});
});
