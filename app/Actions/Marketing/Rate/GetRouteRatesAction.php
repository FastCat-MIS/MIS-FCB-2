<?php

// App\Actions\Marketing\Rate\GetRouteRatesAction.php

namespace App\Actions\Marketing\Rate;

use App\Models\Operations\Route;

class GetRouteRatesAction
{
    public function execute(Route $route)
    {
        return response()->json([
            'route_id' => $route->route_id,
            'accommodations' => $route->rates->map(function ($rate) {
                return [
                    'accommodation' => $rate->seat_class,
                    'baseRate'      => $rate->base_rate,
                    'withoutAC'     => $rate->without_ac ?? null,
                    'updatedBy'     => $rate->updated_by ?? 'system',
                    'status'        => $rate->status,
                ];
            }),
        ]);
    }
}
