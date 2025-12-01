<?php

namespace App\Actions\Operations\ConnectingTrip;

use App\Actions\Action;
use App\Models\Operations\ConnectingTrip;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class CreateConnectingTripAction extends Action
{
    public function execute(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'booking_id'  => 'required|exists:bookings,booking_id',
                'schedule_id' => 'required|exists:schedules,sched_id',
                'leg'         => 'required|integer|min:1',
                'route_id'    => 'required|exists:routes,route_id',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $trip = ConnectingTrip::create($data);
            $trip->load(['booking', 'schedule', 'route.portA', 'route.portB']);

            // Add port names
            if ($trip->route) {
                $trip->route->port_a_name = $trip->route->portA?->name;
                $trip->route->port_b_name = $trip->route->portB?->name;
            }

            return $this->success(['connecting_trip' => $trip], 'Connecting trip created successfully', 201);
        } catch (\Throwable $e) {
            throw new Exception('Failed to create connecting trip: ' . $e->getMessage(), 500);
        }
    }
}
