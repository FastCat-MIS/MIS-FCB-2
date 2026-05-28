<?php

namespace App\Actions\Teller\BookedVehicle;

use App\Actions\Action;
use App\Models\Teller\BookedVehicle;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class DeleteBookedVehicleAction extends Action
{
    public function execute(int $bookedVehicleId)
    {
        // Validate ID is provided and valid
        if ($bookedVehicleId <= 0) {
            return $this->error('Invalid vehicle ID provided. Please provide a valid temp_booked_vehicle_id in the URL: DELETE /teller-booking/book-vehicle/{id}', 400);
        }

        try {
            $bookedVehicle = BookedVehicle::findOrFail($bookedVehicleId);
            $bookedVehicle->delete();

            return $this->success([], 'Booked vehicle deleted successfully', 204);
        } catch (ModelNotFoundException $e) {
            throw new RuntimeException("Booked vehicle with ID {$bookedVehicleId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to delete booked vehicle.');
        }
    }
}

