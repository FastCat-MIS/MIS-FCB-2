<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Port;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        $ports = [
            ['port_name' => 'Batangas Port', 'corridor' => 'Eastern', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Calapan Port', 'corridor' => 'Eastern', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Dumaguete Port', 'corridor' => 'Western', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
            ['port_name' => 'Dapitan Port', 'corridor' => 'Western', 'facilities' => 'Ramp', 'last_update_by' => 'Admin', 'is_active' => true],
        ];

        foreach ($ports as $port) {
            Port::updateOrCreate(['port_name' => $port['port_name']], $port);
        }
    }
}
