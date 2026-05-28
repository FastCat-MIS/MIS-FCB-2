<?php

namespace App\Actions\Teller\BookedVehicle;

use App\Actions\Action;
use App\Models\Teller\BookedVehicle;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class GetBookedVehicleAction extends Action
{
    public function execute(int $bookedVehicleId)
    {
        // Validate ID is provided and valid
        if ($bookedVehicleId <= 0) {
            return $this->error('Invalid vehicle ID provided. Please provide a valid temp_booked_vehicle_id in the URL: GET /teller-booking/book-vehicle/{id}', 400);
        }

        try {
            $bookedVehicle = BookedVehicle::findOrFail($bookedVehicleId);

            return $this->success([
                'booked_vehicle' => $bookedVehicle,
            ], 'Booked vehicle retrieved successfully');
        } catch (ModelNotFoundException $e) {
            throw new RuntimeException("Booked vehicle with ID {$bookedVehicleId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve booked vehicle.');
        }
    }
}

