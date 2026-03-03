<?php

namespace App\Actions\Marketing\Rate\VehicleRates;

use App\Actions\Action;
use App\Models\Marketing\VehicleRate;
use RuntimeException;

class GetRouteVehicleRatesAction extends Action
{
    public function execute(int $routeId)
    {
        try {
            $vehicleRates = VehicleRate::with([
                    'vehicle',                    
                ])
                ->where('route_id', $routeId)
                ->get();

            return $this->success([
                'vehicleRates' => $vehicleRates,
            ], 'Vehicle rates retrieved successfully');

        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve vehicle rates.');  
        }
    }
}