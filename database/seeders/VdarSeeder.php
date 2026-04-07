<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Vdar;
use App\Models\Operations\Vessel;
use App\Models\Operations\Schedule;
use App\Models\Accounts\User;

class VdarSeeder extends Seeder
{
    public function run(): void
    {
        $vessel = Vessel::first();
        $schedule = Schedule::first();
        $vesselMaster = User::where('email', 'vesselmaster@example.com')->first();

        if (!$vessel || !$schedule || !$vesselMaster) {
            $this->command->warn('Missing vessel, schedule, or vessel master. Please seed those first.');
            return;
        }

        $records = [
            [
                'vessel_id'               => $vessel->id,
                'schedule_id'             => $schedule->sched_id,
                'vessel_master_id'        => $vesselMaster->id,
                'voyage_number'           => 1,
                'recorded_sailing_speed'  => 22,
                'water_consumption'       => 150,
                'fuel_rob'                => 3200,
                'reason_of_delay'         => null,
                'actual_departure_time'   => '2026-04-07 07:05:00',
                'actual_arrival_time'     => '2026-04-07 08:10:00',
                'ram_disengage_time'      => '2026-04-07 07:02:00',
                'undock_time'             => '2026-04-07 07:04:00',
            ],
            [
                'vessel_id'               => $vessel->id,
                'schedule_id'             => $schedule->sched_id,
                'vessel_master_id'        => $vesselMaster->id,
                'voyage_number'           => 2,
                'recorded_sailing_speed'  => 20,
                'water_consumption'       => 160,
                'fuel_rob'                => 3050,
                'reason_of_delay'         => 'Heavy port traffic',
                'actual_departure_time'   => '2026-04-07 12:20:00',
                'actual_arrival_time'     => '2026-04-07 13:30:00',
                'ram_disengage_time'      => '2026-04-07 12:15:00',
                'undock_time'             => '2026-04-07 12:18:00',
            ],
        ];

        foreach ($records as $record) {
            Vdar::create($record);
        }

        $this->command->info(count($records) . ' VDAR records seeded successfully.');
    }
}
