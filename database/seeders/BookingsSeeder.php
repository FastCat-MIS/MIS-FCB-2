<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Booking;
use App\Models\Operations\Schedule;

class BookingsSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = Schedule::all();

        if ($schedules->isEmpty()) {
            $this->command->warn('No schedules found. Please seed schedules first.');
            return;
        }

        $bookings = [];
        $counter = 1;

        foreach ($schedules as $schedule) {
            // Create 2 bookings per schedule as example
            for ($i = 1; $i <= 2; $i++) {
                $bookings[] = [
                    'sched_id' => $schedule->sched_id,
                    'booking_number' => sprintf('WLK-%09d-%d', $counter, $i),
                    'booking_date' => now()->format('Y-m-d'),
                    'booking_source' => 'Teller',
                    'vehicle_id' => null,
                    'plate_number' => null,
                    'is_connecting_trip' => (bool)rand(0,1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            $counter++;
        }

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }

        $this->command->info(count($bookings) . ' bookings seeded successfully.');
    }
}
