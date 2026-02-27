<?php

namespace App\Actions\Marketing\Rate\AccommodationRates;

use App\Actions\Action;
use App\Models\Marketing\AccommodationRate;
use RuntimeException;

class GetRouteAccRatesAction extends Action
{
    public function execute(int $routeId)
    {
        try {
            $accRates = AccommodationRate::with([
                    'accommodation',                    
                ])
                ->where('route_id', $routeId)
                ->get();

            return $this->success([
                'accRates' => $accRates,
            ], 'Accommodation rates retrieved successfully');

        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve accommodation rates.');
        }
    }
}