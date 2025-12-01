<?php

namespace App\Actions\Operations\Booking;

use App\Actions\Action;
use App\Models\Operations\Booking;
use RuntimeException;

class DeleteBookingAction extends Action
{
    public function execute(Booking $booking)
    {
        try {
            $booking->delete();
            return $this->success([], 'Booking deleted successfully', 204);
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to delete booking.');
        }
    }
}
