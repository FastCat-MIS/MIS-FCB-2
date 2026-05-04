<?php

namespace App\Actions\Teller\BookedPassenger;

use App\Actions\Action;
use App\Models\Teller\BookedPassenger;
use RuntimeException;

class GetBookedPassengersAction extends Action
{
    public function execute()
    {
        try {
            $bookedPassengers = BookedPassenger::query()
                ->latest('booked_passenger_id')
                ->get();

            return $this->success([
                'booked_passengers' => $bookedPassengers,
            ], 'Booked passengers retrieved successfully');
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve booked passengers.');
        }
    }
}

