<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Route;

class RoutesTableSeeder extends Seeder
{
    public function run()
    {
        $routes = [
            ['port_a' => 'Batangas Port', 'port_b' => 'Calapan Port'],
            ['port_a' => 'Dumaguete Port', 'port_b' => 'Dapitan Port'],
            ['port_a' => 'San Carlos Port', 'port_b' => 'Toledo Port'],
        ];

        foreach ($routes as $route) {
            Route::updateOrCreate(
                [
                    'port_a' => $route['port_a'],
                    'port_b' => $route['port_b'],
                ],
                $route
            );
        }
    }
}
