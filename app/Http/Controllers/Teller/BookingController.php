<?php

namespace App\Http\Controllers\Teller;

use App\Actions\Teller\Booking\CancelTempBookingAction;
use App\Actions\Teller\Booking\GetBookingAction;
use App\Actions\Teller\Booking\GetBookingsAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Get all bookings with passengers and vehicles
     * 
     * GET /teller-booking/bookings?serial_no=BK-123&schedule_id=5&travel_date=2026-05-27
     */
    public function index(Request $request, GetBookingsAction $action)
    {
        return $action->execute($request->all());
    }

    /**
     * Get single booking by serial_no
     *
     * GET /teller-booking/bookings/{serial_no}
     */
    public function show(string $serialNo, GetBookingAction $action)
    {
        return $action->execute($serialNo);
    }

    /**
     * Cancel a pending booking (pre-payment)
     *
     * DELETE /teller-booking/bookings/{serialNo}
     */
    public function destroy(string $serialNo, CancelTempBookingAction $action)
    {
        return $action->execute($serialNo);
    }
}
