<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\VehicleGroup;

class VehicleGroupsTableSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['label' => 'Two-Wheeled Vehicles'],
            ['label' => 'Light Vehicles'],
            ['label' => 'Medium Sized Vehicles'],
        ];

        foreach ($groups as $group) {
            VehicleGroup::firstOrCreate($group);
        }

        $this->command->info('Vehicle groups seeded successfully!');
    }
}
