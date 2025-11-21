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

        $schedules = [];

        foreach ($routes as $route) {
            // Example: 2 schedules departing from port A
            $schedules[] = [
                'departure_time' => '07:00:00',
                'vessel' => 'M15',
                'route_id' => $route->route_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $schedules[] = [
                'departure_time' => '12:00:00',
                'vessel' => 'M19',
                'route_id' => $route->route_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Optional: 1 schedule for port B if needed
            $schedules[] = [
                'departure_time' => '15:00:00',
                'vessel' => 'M21',
                'route_id' => $route->route_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($schedules as $sched) {
            Schedule::create($sched);
        }
    }
}
