<?php

namespace App\Actions\Operations\ConnectingTrip;

use App\Actions\Action;
use App\Models\Operations\ConnectingTrip;
use Exception;

class GetConnectingTripsAction extends Action
{
    public function execute()
    {
        try {
            $trips = ConnectingTrip::with(['booking', 'schedule', 'route.portA', 'route.portB'])->get();

            // Add port names
            $trips = $trips->map(function ($trip) {
                if ($trip->route) {
                    $trip->route->port_a_name = $trip->route->portA?->name;
                    $trip->route->port_b_name = $trip->route->portB?->name;
                }
                return $trip;
            });

            return $this->success(['connecting_trips' => $trips], 'Connecting trips retrieved successfully');
        } catch (\Throwable $e) {
            throw new Exception('Failed to retrieve connecting trips: ' . $e->getMessage(), 500);
        }
    }
}
