<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Route;
use App\Models\Operations\Port;

class RoutesTableSeeder extends Seeder
{
    public function run(): void
    {
        $ports = Port::all();

        if ($ports->count() < 2) {
            $this->command->warn('Not enough ports to create routes. Seed ports first.');
            return;
        }

        $routesData = [
            ['port_a_id' => $ports[0]->port_id, 'port_b_id' => $ports[1]->port_id],
            ['port_a_id' => $ports[0]->port_id, 'port_b_id' => $ports[2]->port_id ?? $ports[1]->port_id],
            ['port_a_id' => $ports[1]->port_id, 'port_b_id' => $ports[3]->port_id ?? $ports[0]->port_id],
        ];

        foreach ($routesData as $data) {
            Route::updateOrCreate(
                ['port_a_id' => $data['port_a_id'], 'port_b_id' => $data['port_b_id']],
                $data
            );
        }

        $this->command->info(count($routesData) . ' routes seeded successfully.');
    }
}
