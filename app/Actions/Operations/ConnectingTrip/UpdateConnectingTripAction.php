<?php

namespace App\Actions\Operations\ConnectingTrip;

use App\Actions\Action;
use App\Models\Operations\ConnectingTrip;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class UpdateConnectingTripAction extends Action
{
    public function execute(ConnectingTrip $trip, array $data)
    {
        try {
            $validator = Validator::make($data, [
                'booking_id'  => 'sometimes|required|exists:bookings,booking_id',
                'schedule_id' => 'sometimes|required|exists:schedules,sched_id',
                'leg'         => 'sometimes|required|integer|min:1',
                'route_id'    => 'sometimes|required|exists:routes,route_id',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $trip->update($data);
            $trip->load(['booking', 'schedule', 'route.portA', 'route.portB']);

            // Add port names
            if ($trip->route) {
                $trip->route->port_a_name = $trip->route->portA?->name;
                $trip->route->port_b_name = $trip->route->portB?->name;
            }

            return $this->success(['connecting_trip' => $trip], 'Connecting trip updated successfully');
        } catch (\Throwable $e) {
            throw new Exception('Failed to update connecting trip: ' . $e->getMessage(), 500);
        }
    }
}
