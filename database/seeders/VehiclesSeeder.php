<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Vehicle;

class VehiclesSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            [
              'vehicle_type'=>1,
              'vehicle_class'=>'Bicycle',
            ],
            [
              'vehicle_type'=>1,
              'vehicle_class'=>'Bicycle with side car',
            ],
            [
              'vehicle_type'=>2,
              'vehicle_class'=>'Van',
            ],
            [
              'vehicle_type'=>2,
              'vehicle_class'=>'Pickup',
            ],
            [
              'vehicle_type'=>2,
              'vehicle_class'=>'Forward',
            ]
        ];

        foreach ($vehicles as $vehicle) {
            $vehicle = Vehicle::create($vehicle);
        }

        $this->command->info('Vehicles seeded successfully!');
    }
}
