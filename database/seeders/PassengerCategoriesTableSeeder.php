<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PassengerCategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $categories = [
            ['p_ctgry_id' => 1, 'category' => 'passenger', 'created_at' => $now, 'updated_at' => $now],
            ['p_ctgry_id' => 2, 'category' => 'driver', 'created_at' => $now, 'updated_at' => $now],
            ['p_ctgry_id' => 3, 'category' => 'bus & trucks', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('passenger_categories')->insert($categories);

        $this->command->info('Passenger Categories seeded successfully!');
    }
}
