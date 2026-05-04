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

