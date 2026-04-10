<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Schedule;
use App\Models\Operations\Port;
use App\Models\Operations\Vessel;

class SchedulesTableSeeder extends Seeder
{
    public function run(): void
    {
        $ports = Port::all();
        $vessels = Vessel::all();

        if ($ports->isEmpty()) {
            $this->command->warn('No ports found. Please seed ports first.');
            return;
        }

        if ($vessels->isEmpty()) {
            $this->command->warn('No vessels found. Please seed vessels first.');
            return;
        }

        $schedules = [];
        $vesselCount = $vessels->count();

        // Assign each vessel to only one port (distribute vessels across ports)
        foreach ($vessels as $index => $vessel) {
            // Each vessel gets assigned to one port only
            $port = $ports->get($index % $ports->count());

            $schedules[] = ['departure_time' => '07:00:00', 'arrival_time' => '08:00:00', 'vessel_id' => $vessel->id, 'port_id' => $port->port_id, 'status' => 1, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()];
            $schedules[] = ['departure_time' => '12:00:00', 'arrival_time' => '13:00:00', 'vessel_id' => $vessel->id, 'port_id' => $port->port_id, 'status' => 1, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()];
            $schedules[] = ['departure_time' => '15:00:00', 'arrival_time' => '16:00:00', 'vessel_id' => $vessel->id, 'port_id' => $port->port_id, 'status' => 1, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()];
        }

        foreach ($schedules as $sched) {
            Schedule::updateOrCreate(
                ['departure_time' => $sched['departure_time'], 'vessel_id' => $sched['vessel_id']],
                $sched
            );
        }

        $this->command->info(count($schedules) . ' schedules seeded successfully.');
        $this->command->info('Each vessel is assigned to only one port.');
    }
}
