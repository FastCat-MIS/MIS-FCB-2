<?php

namespace App\Actions\Operations\BookedPassenger;

use App\Actions\Action;
use App\Models\Operations\BookedPassenger;
use RuntimeException;

class DeleteBookedPassengerAction extends Action
{
    public function execute(BookedPassenger $bookedPassenger)
    {
        try {
            $bookedPassenger->delete();
            return $this->success([], 'Booked passenger deleted successfully', 204);
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to delete booked passenger.');
        }
    }
}
