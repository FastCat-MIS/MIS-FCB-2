<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Port;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        $ports = [
            ['port_name' => 'Batangas Port',     'corridor' => 'Eastern', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Calapan Port',      'corridor' => 'Eastern', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Bulalacao Port',    'corridor' => 'Eastern', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Caticlan Port',     'corridor' => 'Western', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Dumangas Port',     'corridor' => 'Western', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Banago Port',       'corridor' => 'Western', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Dumaguete Port',    'corridor' => 'Western', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Dapitan Port',      'corridor' => 'Western', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'San Carlos Port',   'corridor' => 'Western', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Toledo Port',       'corridor' => 'Western', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Cebu Port',         'corridor' => 'Central', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Tubigon Port',      'corridor' => 'Central', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Matnog Port',       'corridor' => 'Eastern', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Dap Dap Port',      'corridor' => 'Central', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Maasin Port',       'corridor' => 'Eastern', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Surigao Port',      'corridor' => 'Eastern', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Zamboanga Port',    'corridor' => 'Western', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Basilan Port',      'corridor' => 'Western', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
        ];

        foreach ($ports as $port) {
            Port::updateOrCreate(
                ['port_name' => $port['port_name']],
                $port
            );
        }

        $this->command->info(count($ports) . ' ports seeded successfully.');
    }
}