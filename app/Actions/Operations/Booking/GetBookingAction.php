<?php

namespace App\Actions\Operations\Booking;

use App\Actions\Action;
use App\Models\Operations\Booking;
use RuntimeException;

class GetBookingAction extends Action
{
    public function execute(Booking $booking)
    {
        try {
            return $this->success(['booking' => $booking], 'Booking retrieved successfully');
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve booking.');
        }
    }
}
