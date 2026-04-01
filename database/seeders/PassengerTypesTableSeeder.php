<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassengerTypesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('passenger_types')->insert([
            ['p_id' => 1, 'type' => 'regular passenger','discount' => 0, 'waived' => false, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['p_id' => 2, 'type' => 'Institutional Account', 'discount' => 0, 'waived' => false, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->command->info('Passenger types seeded successfully!');
    }
}
