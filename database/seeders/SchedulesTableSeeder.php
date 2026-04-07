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
        $vessel = Vessel::first();

        if ($ports->isEmpty()) {
            $this->command->warn('No ports found. Please seed ports first.');
            return;
        }

        if (!$vessel) {
            $this->command->warn('No vessels found. Please seed vessels first.');
            return;
        }

        $schedules = [];
        foreach ($ports as $port) {
            $schedules[] = ['departure_time' => '07:00:00', 'arrival_time' => '08:00:00', 'vessel_id' => $vessel->id, 'port_id' => $port->port_id, 'status' => 1, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()];
            $schedules[] = ['departure_time' => '12:00:00', 'arrival_time' => '13:00:00', 'vessel_id' => $vessel->id, 'port_id' => $port->port_id, 'status' => 1, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()];
            $schedules[] = ['departure_time' => '15:00:00', 'arrival_time' => '16:00:00', 'vessel_id' => $vessel->id, 'port_id' => $port->port_id, 'status' => 1, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()];
        }

        foreach ($schedules as $sched) {
            Schedule::updateOrCreate(
                ['departure_time' => $sched['departure_time'], 'port_id' => $sched['port_id']],
                $sched
            );
        }

        $this->command->info(count($schedules) . ' schedules seeded successfully.');
    }
}
