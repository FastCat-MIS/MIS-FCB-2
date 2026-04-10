<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Vdar;
use App\Models\Operations\Vessel;
use App\Models\Operations\Schedule;
use App\Models\Operations\Port;
use App\Models\Accounts\User;

class VdarSeeder extends Seeder
{
    public function run(): void
    {
        $vessel = Vessel::first();
        $schedule = Schedule::first();
        $port = Port::first();
        $vesselMaster = User::where('email', 'vesselmaster@example.com')->first();

        if (!$vessel || !$schedule || !$port || !$vesselMaster) {
            $this->command->warn('Missing vessel, schedule, port, or vessel master. Please seed those first.');
            return;
        }

        $records = [
            [
                'port_id'                 => $port->port_id,
                'vessel_id'               => $vessel->id,
                'schedule_id'             => $schedule->sched_id,
                'vessel_master_id'        => $vesselMaster->id,
                'voyage_number'           => 1,
                'recorded_sailing_speed'  => 22,
                'water_consumption'       => 150,
                'fuel_rob'                => 3200,
                'reason_of_delay'         => 'Mechanical issues',
                'actual_departure_time'   => '07:05:00',
                'actual_arrival_time'     => '08:10:00',
                'ram_disengage_time'      => '07:02:00',
                'undock_time'             => 4,
            ],
            [
                'port_id'                 => $port->port_id,
                'vessel_id'               => $vessel->id,
                'schedule_id'             => $schedule->sched_id,
                'vessel_master_id'        => $vesselMaster->id,
                'voyage_number'           => 2,
                'recorded_sailing_speed'  => 20,
                'water_consumption'       => 160,
                'fuel_rob'                => 3050,
                'reason_of_delay'         => 'Heavy port traffic',
                'actual_departure_time'   => '12:20:00',
                'actual_arrival_time'     => '13:30:00',
                'ram_disengage_time'      => '12:15:00',
                'undock_time'             => 18,
            ],
        ];

        foreach ($records as $record) {
            $now       = now();
            $portPart  = str_pad($record['port_id'], 2, '0', STR_PAD_LEFT);
            $yearHex   = strtoupper(dechex($now->year));
            $monthHex  = strtoupper(dechex($now->month));
            $count     = Vdar::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->count();
            $countPart = str_pad($count, 4, '0', STR_PAD_LEFT);

            $record['control_number'] = "{$portPart}{$yearHex}{$monthHex}-{$countPart}";

            Vdar::create($record);
        }

        $this->command->info(count($records) . ' VDAR records seeded successfully.');
    }
}
