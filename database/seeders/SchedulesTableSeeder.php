<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Schedule;
use App\Models\Operations\Route;

class SchedulesTableSeeder extends Seeder
{
    public function run(): void
    {
        $routes = Route::all();

        if ($routes->isEmpty()) {
            $this->command->warn('No routes found. Please seed routes first.');
            return;
        }

        $schedules = [];

        foreach ($routes as $route) {
            // Example schedules for this route
            $schedules[] = [
                'departure_time' => '07:00:00',
                'route_id' => $route->route_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $schedules[] = [
                'departure_time' => '12:00:00',
                'route_id' => $route->route_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $schedules[] = [
                'departure_time' => '15:00:00',
                'route_id' => $route->route_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($schedules as $sched) {
            Schedule::create($sched);
        }

        $this->command->info(count($schedules) . ' schedules seeded successfully.');
    }
}
