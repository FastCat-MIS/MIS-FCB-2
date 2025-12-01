<?php

namespace App\Actions\Operations\ConnectingTrip;

use App\Actions\Action;
use App\Models\Operations\ConnectingTrip;
use Exception;

class DeleteConnectingTripAction extends Action
{
    public function execute(ConnectingTrip $trip)
    {
        try {
            $trip->delete();
            return $this->success([], 'Connecting trip deleted successfully', 204);
        } catch (\Throwable $e) {
            throw new Exception('Failed to delete connecting trip: ' . $e->getMessage(), 500);
        }
    }
}
