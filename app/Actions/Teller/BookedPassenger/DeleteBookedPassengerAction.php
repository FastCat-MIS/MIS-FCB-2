<?php

namespace App\Actions\Teller\BookedPassenger;

use App\Actions\Action;
use App\Models\Teller\BookedPassenger;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class DeleteBookedPassengerAction extends Action
{
    public function execute(int $bookedPassengerId)
    {
        try {
            $bookedPassenger = BookedPassenger::findOrFail($bookedPassengerId);
            $bookedPassenger->delete();

            return $this->success([], 'Booked passenger deleted successfully', 204);
        } catch (ModelNotFoundException $e) {
            throw new RuntimeException("Booked passenger with ID {$bookedPassengerId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to delete booked passenger.');
        }
    }
}

