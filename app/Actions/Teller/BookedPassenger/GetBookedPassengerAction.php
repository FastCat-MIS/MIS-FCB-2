<?php

namespace App\Actions\Teller\BookedPassenger;

use App\Actions\Action;
use App\Models\Teller\BookedPassenger;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class GetBookedPassengerAction extends Action
{
    public function execute(int $bookedPassengerId)
    {
        // Validate ID is provided and valid
        if ($bookedPassengerId <= 0) {
            return $this->error('Invalid passenger ID provided. Please provide a valid temp_booked_passenger_id in the URL: GET /teller-booking/book-passenger/{id}', 400);
        }

        try {
            $bookedPassenger = BookedPassenger::findOrFail($bookedPassengerId);

            return $this->success([
                'booked_passenger' => $bookedPassenger,
            ], 'Booked passenger retrieved successfully');
        } catch (ModelNotFoundException $e) {
            throw new RuntimeException("Booked passenger with ID {$bookedPassengerId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve booked passenger.');
        }
    }
}

