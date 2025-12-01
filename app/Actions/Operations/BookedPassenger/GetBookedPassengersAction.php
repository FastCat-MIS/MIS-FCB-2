<?php

namespace App\Actions\Operations\BookedPassenger;

use App\Actions\Action;
use App\Models\Operations\BookedPassenger;
use RuntimeException;

class GetBookedPassengersAction extends Action
{
    public function execute()
    {
        try {
            $bookedPassengers = BookedPassenger::with(['booking', 'discount'])->get();
            return $this->success(['booked_passengers' => $bookedPassengers], 'Booked passengers retrieved successfully');
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve booked passengers.');
        }
    }
}
