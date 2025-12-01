<?php

namespace App\Actions\Operations\ConnectingTrip;

use App\Actions\Action;
use App\Models\Operations\ConnectingTrip;
use Exception;

class GetConnectingTripByKeywordAction extends Action
{
    /**
     * Search connecting trips by keyword in booking, ports, or schedule.
     *
     * @param string $keyword
     * @return array
     */
    public function execute(string $keyword)
    {
        try {
            $trips = ConnectingTrip::with(['booking', 'schedule', 'route.portA', 'route.portB'])
                ->whereHas('booking', function ($q) use ($keyword) {
                    $q->where('booking_number', 'like', "%$keyword%");
                })
                ->orWhereHas('route', function ($q) use ($keyword) {
                    $q->whereHas('portA', function ($q2) use ($keyword) {
                        $q2->where('port_name', 'like', "%$keyword%");
                    })
                    ->orWhereHas('portB', function ($q3) use ($keyword) {
                        $q3->where('port_name', 'like', "%$keyword%");
                    });
                })
                ->orWhereHas('schedule', function ($q) use ($keyword) {
                    $q->where('sched_id', 'like', "%$keyword%");
                })
                ->get();

            // Transform trips to include port names for response
            $trips = $trips->map(function ($trip) {
                if ($trip->route) {
                    $trip->route->port_a_name = $trip->route->portA?->port_name;
                    $trip->route->port_b_name = $trip->route->portB?->port_name;
                }
                return $trip;
            });

            return $this->success(['connecting_trips' => $trips], 'Connecting trips retrieved successfully');
        } catch (\Throwable $e) {
            throw new Exception('Failed to retrieve connecting trips: ' . $e->getMessage(), 500);
        }
    }
}
