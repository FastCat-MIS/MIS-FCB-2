<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\VehicleType;
use App\Models\Operations\VehicleGroup;

class VehicleTypesTableSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Two-Wheeled Vehicles' => [
                ['label' => 'Motorcycle', 'type_code' => 'motorcycle'],
                ['label' => 'MC > 400 CC', 'type_code' => 'mc400'],
                ['label' => 'Bicycle', 'type_code' => 'bicycle'],
            ],
            'Light Vehicles' => [
                ['label' => 'Tricycle', 'type_code' => 'tricycle'],
                ['label' => 'Light Car', 'type_code' => 'lightcar'],
            ],
            'Medium Sized Vehicles' => [
                ['label' => 'Van', 'type_code' => 'van'],
                ['label' => 'Pickup', 'type_code' => 'pickup'],
            ],
        ];

        foreach ($types as $groupLabel => $groupTypes) {
            $group = VehicleGroup::where('label', $groupLabel)->first();
            if (!$group) continue;

            foreach ($groupTypes as $type) {
                VehicleType::firstOrCreate(
                    [
                        'group_id' => $group->group_id,
                        'type_code' => $type['type_code']
                    ],
                    ['label' => $type['label']]
                );
            }
        }

        $this->command->info('Vehicle types seeded successfully!');
    }
}
