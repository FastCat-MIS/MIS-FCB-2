<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\ConnectingTrip;

class ConnectingTripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example connecting trips
        $trips = [
            [
                'booking_id'  => 1,
                'schedule_id' => 1,
                'leg'         => 1,
                'route_id'    => 1, // replace with actual route id
            ],
            [
                'booking_id'  => 1,
                'schedule_id' => 6,
                'leg'         => 2,
                'route_id'    => 2,
            ],
            [
                'booking_id'  => 1,
                'schedule_id' => 8,
                'leg'         => 3,
                'route_id'    => 3,
            ],
        ];

        foreach ($trips as $trip) {
            ConnectingTrip::create($trip);
        }
    }
}
