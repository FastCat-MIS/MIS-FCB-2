<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Vessel;


class VesselSeeder extends Seeder
{
    public function run(): void
    {
     
        $vessels = [
            [
                'vessel_name' => 'FCM12',
                'capacity'    => 500,
                'description' => 'High-speed passenger ferry',
                'status'      => 1,
            ],
            [
                'vessel_name' => 'FCM13',
                'capacity'    => 450,
                'description' => 'High-speed passenger and vehicle ferry',
                'status'      => 1,
            ],
            [
                'vessel_name' => 'FCM14',
                'capacity'    => 600,
                'description' => 'Large capacity passenger ferry',
                'status'      => 1,
            ],
        ];

        foreach ($vessels as $vessel) {
            Vessel::updateOrCreate(
                ['vessel_name' => $vessel['vessel_name']],
                $vessel
            );
        }
        $this->command->info(count($vessels) . ' vessels seeded successfully.');
    }
}
