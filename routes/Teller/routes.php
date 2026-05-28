<?php

use App\Http\Controllers\Teller\BookedPassengerController;
use App\Http\Controllers\Teller\BookedVehicleController;
use App\Http\Controllers\Teller\BookingController;
use App\Http\Controllers\Teller\PaymentController;
use App\Http\Controllers\Teller\SeatController;
use Illuminate\Support\Facades\Route;

// Generate share token without authentication
Route::get('/teller-booking/share-token', function () {
    return app(\App\Actions\Teller\GenerateShareTokenAction::class)->execute();
});

Route::middleware('pem.jwt:payment.read')->group(function () {
    Route::prefix('teller-booking')->group(function () {
        // Temp booking endpoints
        Route::get('/bookings', [BookingController::class, 'index']);
        Route::get('/bookings/{serialNo}', [BookingController::class, 'show']);
        
        // Create temp bookings
        Route::post('/booked-passengers', [BookedPassengerController::class, 'store']);
        Route::post('/booked-vehicles', [BookedVehicleController::class, 'store']);

        // Completed bookings (after payment)
        Route::get('/completed-bookings', [PaymentController::class, 'index']);
        Route::get('/completed-bookings/{paymentId}', [PaymentController::class, 'show']);
        
        // Process payment
        Route::post('/payment', [PaymentController::class, 'store']);

        // Seat availability
        Route::post('/check-seat', [SeatController::class, 'checkSeat']);
        Route::get('/schedule-seats', [SeatController::class, 'getScheduleSeats']);
        Route::get('/booked-seats', [SeatController::class, 'getBookedSeats']);
    });
});
