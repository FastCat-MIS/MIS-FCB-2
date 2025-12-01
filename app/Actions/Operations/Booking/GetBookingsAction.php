<?php

namespace App\Actions\Operations\Booking;

use App\Actions\Action;
use App\Models\Operations\Booking;
use RuntimeException;

class GetBookingsAction extends Action
{
    public function execute()
    {
        try {
            $bookings = Booking::with('schedule')->get();
            return $this->success(['bookings' => $bookings], 'Bookings retrieved successfully');
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve bookings.');
        }
    }
}
