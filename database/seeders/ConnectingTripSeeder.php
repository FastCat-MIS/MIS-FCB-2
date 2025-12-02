<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\ConnectingTrip;
use App\Models\Operations\Schedule;
use App\Models\Operations\Route;

class ConnectingTripSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = Schedule::all();
        $routes = Route::all();

        if ($schedules->isEmpty() || $routes->isEmpty()) {
            $this->command->warn('Schedules or Routes are missing. Seed them first.');
            return;
        }

        // Example connecting trips: pair first three schedules and routes dynamically
        $trips = [];
        for ($i = 0; $i < min(3, $schedules->count(), $routes->count()); $i++) {
            $trips[] = [
                'booking_id' => 1, // Replace or dynamically fetch bookings
                'schedule_id' => $schedules[$i]->sched_id,
                'leg' => $i + 1,
                'route_id' => $routes[$i]->route_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($trips as $trip) {
            ConnectingTrip::updateOrCreate(
                ['schedule_id' => $trip['schedule_id'], 'leg' => $trip['leg']],
                $trip
            );
        }

        $this->command->info(count($trips) . ' connecting trips seeded successfully.');
    }
}
