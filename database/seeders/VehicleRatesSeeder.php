<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marketing\VehicleRate;
use App\Models\Operations\Vehicle;
use App\Models\Operations\Route;

class VehicleRatesSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = Vehicle::all();
        $routes = Route::all();

        if ($vehicles->isEmpty() || $routes->isEmpty()) {
            $this->command->warn('No vehicles or routes found. Skipping VehicleRate seeding.');
            return;
        }

        foreach ($vehicles as $vehicle) {
            foreach ($routes as $route) {

                VehicleRate::create([
                    'vehicle_id'     => $vehicle->vehicle_id,
                    'route_id'       => $route->route_id,
                    'vehicle_rate'   => rand(1000, 5000), 
                    'status'         => 1,
                ]);
            }
        }

        $this->command->info('Vehicle rates seeded successfully.');
    }
}