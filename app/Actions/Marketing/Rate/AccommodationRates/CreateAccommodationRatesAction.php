<?php

namespace App\Actions\Marketing\Rate\AccommodationRates;

use App\Actions\Action;
use App\Models\Operations\Route;
use App\Models\Marketing\AccommodationRate;
use App\Models\Operations\PassengerAccommodation;
use Illuminate\Support\Facades\DB;

class CreateAccommodationRatesAction extends Action
{
    public function execute($accommodation)
    {
        DB::beginTransaction();

        try {

            $routes = Route::all();

            foreach ($routes as $route) {
                AccommodationRate::create([
                    'route_id' => $route->route_id,
                    'accommodation_id' => $accommodation->accommodation_id,
                    'base_rate' => 0,
                    'effective_date' => now(),
                    'status' => 'active',
                ]);
            }

            DB::commit();

            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}