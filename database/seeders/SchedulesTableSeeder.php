<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchedulesTableSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = [
            [
                'sched_id' => 1,
                'departure_time' => '12:00',
                'vessel' => 'M19',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sched_id' => 2,
                'departure_time' => '07:00',
                'vessel' => 'M15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sched_id' => 3,
                'departure_time' => '15:00',
                'vessel' => 'M19',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('schedules')->insert($schedules);
    }
}
