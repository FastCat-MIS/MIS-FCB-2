<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Route;
use App\Models\Operations\PassengerAccommodation;
use App\Models\Marketing\AccommodationRate;

class AccommodationRatesSeeder extends Seeder
{
    public function run(): void
    {
        $routes = Route::all();
        $accommodations = PassengerAccommodation::all();

        foreach ($routes as $route) {
            foreach ($accommodations as $accommodation) {
                
                $exists = AccommodationRate::where('route_id', $route->route_id)
                    ->where('accommodation_id', $accommodation->accommodation_id)
                    ->exists();

                if (!$exists) {
                    AccommodationRate::create([
                        'route_id' => $route->route_id,
                        'accommodation_id' => $accommodation->accommodation_id,
                        'base_rate' => rand(500, 2000), 

                        'status' => 1,
                    ]);
                }
            }
        }
    }
}