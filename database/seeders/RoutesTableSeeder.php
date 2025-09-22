<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoutesTableSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            [
                'route_id' => 1,
                'origin' => 'Batangas',
                'destination' => 'Calapan',
                'distance' => 50,
                'estimated_duration' => 120,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'route_id' => 2,
                'origin' => 'Calapan',
                'destination' => 'Batangas',
                'distance' => 50,
                'estimated_duration' => 120,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'route_id' => 3,
                'origin' => 'Dumaguete',
                'destination' => 'Dapitan',
                'distance' => 200,
                'estimated_duration' => 300,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'route_id' => 4,
                'origin' => 'Calapan',
                'destination' => 'Caticlan',
                'distance' => 150,
                'estimated_duration' => 240,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('routes')->insert($routes);

        $this->command->info('Routes seeded successfully!');
    }
}
