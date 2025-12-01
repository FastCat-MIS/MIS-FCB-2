<?php

namespace App\Actions\Operations\ConnectingTrip;

use App\Actions\Action;
use App\Models\Operations\ConnectingTrip;
use RuntimeException;

class GetConnectingTripAction extends Action
{
    /**
     * Retrieve a single connecting trip or all if no ID is provided.
     *
     * @param int|null $connectingTripId
     * @return array
     */
    public function execute(?int $connectingTripId = null)
    {
        try {
            $query = ConnectingTrip::with([
                'booking',
                'schedule',
                'route.portA',
                'route.portB'
            ]);

            // Filter by connecting_trip_id if provided
            if ($connectingTripId) {
                $query->where('connecting_id', $connectingTripId);
            }

            $connectingTrips = $query->get();

            // Transform the route to include port names
            $connectingTrips = $connectingTrips->map(function ($trip) {
                if ($trip->route) {
                    $trip->route->port_a_name = $trip->route->portA?->port_name;
                    $trip->route->port_b_name = $trip->route->portB?->port_name;
                }
                return $trip;
            });

            return $this->success(['connecting_trips' => $connectingTrips], 'Connecting trips retrieved successfully');
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve connecting trips: ' . $e->getMessage());
        }
    }
}
