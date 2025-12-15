<?php

// App\Actions\Marketing\Rate\CreateRouteRateAction.php

namespace App\Actions\Marketing\Rate;

use App\Models\Operations\Route;

class CreateRouteRateAction
{
    public function execute(Route $route, array $data)
    {
        $rate = $route->rates()->create([
            'seat_class'     => $data['seat_class'],
            'base_rate'      => $data['base_rate'],
            'without_ac'     => $data['without_ac'] ?? null,
            'effective_date' => $data['effective_date'] ?? now(),
            'status'         => $data['status'] ?? 'Active',
        ]);

        return response()->json($rate, 201);
    }
}
