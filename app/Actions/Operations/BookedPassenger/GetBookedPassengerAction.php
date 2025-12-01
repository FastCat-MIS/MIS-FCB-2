<?php

namespace App\Actions\Operations\BookedPassenger;

use App\Actions\Action;
use App\Models\Operations\BookedPassenger;
use RuntimeException;

class GetBookedPassengerAction extends Action
{
    public function execute(BookedPassenger $bookedPassenger)
    {
        try {
            $bookedPassenger->load(['booking', 'discount']);
            return $this->success(['booked_passenger' => $bookedPassenger], 'Booked passenger retrieved successfully');
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve booked passenger.');
        }
    }
}
