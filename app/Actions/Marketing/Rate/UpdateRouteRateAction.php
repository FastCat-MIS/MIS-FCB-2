<?php

namespace App\Actions\Marketing\Rate;

use App\Models\Operations\Route;
use App\Models\Marketing\Rate;
use Illuminate\Support\Facades\DB;

class UpdateRouteRateAction
{
    public function execute(Route $route, array $data)
    {
        return DB::transaction(function () use ($route, $data) {

            $updatedRates = collect($data['accommodations'])->map(function ($item) use ($route) {

                $rate = Rate::where('rate_id', $item['rate_id'])
                    ->where('route_id', $route->route_id)
                    ->firstOrFail();

                $rate->update([
                    'seat_class' => $item['seat_class'] ?? $rate->seat_class,
                    'base_rate'  => $item['base_rate'] ?? $rate->base_rate,
                    'without_ac' => $item['without_ac'] ?? $rate->without_ac,
                    'status'     => $item['status'] ?? $rate->status,
                    'updated_by' => $item['updated_by'] ?? auth()->user()->name,
                ]);

                return $rate;
            });

            return response()->json([
                'message' => 'Rates updated successfully',
                'rates'   => $updatedRates,
            ]);
        });
    }
}
