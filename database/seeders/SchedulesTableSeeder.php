<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Schedule;
use App\Models\Operations\Port;

class SchedulesTableSeeder extends Seeder
{
    public function run(): void
    {
        $ports = Port::all();

        if ($ports->isEmpty()) {
            $this->command->warn('No ports found. Please seed ports first.');
            return;
        }

        $schedules = [];
        foreach ($ports as $port) {
            $schedules[] = ['departure_time' => '07:00:00', 'port_id' => $port->port_id, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()];
            $schedules[] = ['departure_time' => '12:00:00', 'port_id' => $port->port_id, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()];
            $schedules[] = ['departure_time' => '15:00:00', 'port_id' => $port->port_id, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()];
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
