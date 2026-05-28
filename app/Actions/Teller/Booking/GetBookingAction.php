<?php

namespace App\Actions\Teller\Booking;

use App\Actions\Action;
use App\Models\Teller\TempBooking;

class GetBookingAction extends Action
{
    public function execute(string $serialNo)
    {
        $booking = TempBooking::with(['passengers', 'vehicles'])
            ->where('serial_no', $serialNo)
            ->first();

        if (!$booking) {
            return $this->error('Booking not found', 404);
        }

        return $this->success([
            'booking' => $booking,
            'passengers_count' => $booking->passengers->count(),
            'vehicles_count' => $booking->vehicles->count(),
        ], 'Booking retrieved successfully');
    }
}
