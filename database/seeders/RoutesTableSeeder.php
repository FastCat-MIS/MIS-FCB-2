<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Route;
use App\Models\Operations\Port;

class RoutesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Get ports indexed by name for easy lookup
        $ports = Port::pluck('port_id', 'port_name');

        $routes = [
            ['Batangas Port', 'Calapan Port'],
            ['Bulalacao Port', 'Caticlan Port'],
            ['Dumangas Port', 'Banago Port'],
            ['Dumaguete Port', 'Dapitan Port'],
            ['San Carlos Port', 'Toledo Port'],
            ['Cebu Port', 'Tubigon Port'],
            ['Matnog Port', 'Dap Dap Port'],
            ['Maasin Port', 'Surigao Port'],
            ['Zamboanga Port', 'Basilan Port'],
        ];

        $created = 0;

        foreach ($routes as [$portA, $portB]) {
            if (!isset($ports[$portA]) || !isset($ports[$portB])) {
                $this->command->warn("Skipping route: $portA - $portB (port not found)");
                continue;
            }

            Route::updateOrCreate(
                [
                    'port_a_id' => $ports[$portA],
                    'port_b_id' => $ports[$portB],
                ],
                [
                    'port_a_id' => $ports[$portA],
                    'port_b_id' => $ports[$portB],
                ]
            );

            $created++;
        }

        $this->command->info($created . ' routes seeded successfully.');
    }
}