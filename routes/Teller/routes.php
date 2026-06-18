<?php

use App\Http\Controllers\Teller\BookedPassengerController;
use App\Http\Controllers\Teller\BookedVehicleController;
use App\Http\Controllers\Teller\BookingController;
use App\Http\Controllers\Teller\PaymentController;
use App\Http\Controllers\Teller\SeatController;
use App\Http\Controllers\Teller\TicketController;
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
        Route::delete('/bookings/{serialNo}', [BookingController::class, 'destroy']);
        
        // Create temp bookings
        Route::post('/booked-passengers', [BookedPassengerController::class, 'store']);
        Route::post('/booked-vehicles', [BookedVehicleController::class, 'store']);
        
        // Update temp bookings (e.g., assign driver)
        Route::patch('/booked-vehicles/{bookedVehicleId}', [BookedVehicleController::class, 'update']);

        // Delete temp bookings
        Route::delete('/booked-passengers/{bookedPassengerId}', [BookedPassengerController::class, 'destroy']);
        
        // Backwards compatibility aliases
        Route::post('/book-passenger', [BookedPassengerController::class, 'store']);
        Route::post('/book-vehicle', [BookedVehicleController::class, 'store']);
        Route::patch('/book-vehicle/{bookedVehicleId}', [BookedVehicleController::class, 'update']);

        // Completed bookings (after payment)
        Route::get('/completed-bookings', [PaymentController::class, 'index']);
        Route::get('/completed-bookings/{paymentId}', [PaymentController::class, 'show']);
        
        // Generate ticket, e-ticket, and waybill
        Route::get('/generate-ticket', [TicketController::class, 'generate']);
        Route::get('/generate-eticket', [TicketController::class, 'generateETicket']);
        Route::get('/generate-waybill', [TicketController::class, 'generateWaybill']);
        
        // Process payment
        Route::post('/payment', [PaymentController::class, 'store']);

        // Seat availability
        Route::post('/check-seat', [SeatController::class, 'checkSeat']);
        Route::get('/schedule-seats', [SeatController::class, 'getScheduleSeats']);
        Route::get('/booked-seats', [SeatController::class, 'getBookedSeats']);
    });
});
