<?php

namespace App\Actions\Teller\BookedVehicle;

use App\Actions\Action;
use App\Models\Teller\BookedVehicle;
use RuntimeException;

class GetBookedVehiclesAction extends Action
{
    public function execute()
    {
        try {
            $bookedVehicles = BookedVehicle::query()
                ->with('tempBooking')
                ->latest('booked_vehicle_id')
                ->get();

            return $this->success([
                'booked_vehicles' => $bookedVehicles,
            ], 'Booked vehicles retrieved successfully');
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve booked vehicles.');
        }
    }
}

