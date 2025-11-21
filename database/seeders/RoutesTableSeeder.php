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

        $routes = [
            ['port_a_id' => $ports[0]->port_id, 'port_b_id' => $ports[1]->port_id],
            ['port_a_id' => $ports[0]->port_id, 'port_b_id' => $ports[2]->port_id],
            ['port_a_id' => $ports[1]->port_id, 'port_b_id' => $ports[3]->port_id],
        ];

        foreach ($routes as $route) {
            Route::updateOrCreate(
                ['port_a_id' => $route['port_a_id'], 'port_b_id' => $route['port_b_id']],
                $route
            );
        }
    }
}
