<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\Port;

class PortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ports = [
            [
                'port_name' => 'Batangas Port',
                'corridor' => 'Eastern',
                'facilities' => 'Ramp',
                'last_update_by' => 'Tovvy B. Dumaplin',
                'is_active' => true,
                'created_at' => '2025-05-02',
                'updated_at' => '2025-08-02',
            ],
            [
                'port_name' => 'Calapan Port',
                'corridor' => 'Eastern',
                'facilities' => 'Ramp',
                'last_update_by' => 'Tovvy B. Dumaplin',
                'is_active' => false,
                'created_at' => '2025-05-03',
                'updated_at' => '2025-08-03',
            ],
            [
                'port_name' => 'Dumaguete Port',
                'corridor' => 'Western',
                'facilities' => 'Ramp',
                'last_update_by' => 'Tovvy B. Dumaplin',
                'is_active' => true,
                'created_at' => '2025-05-04',
                'updated_at' => '2025-08-04',
            ],
            [
                'port_name' => 'Dapitan Port',
                'corridor' => 'Western',
                'facilities' => 'Ramp',
                'last_update_by' => 'Tovvy B. Dumaplin',
                'is_active' => false,
                'created_at' => '2025-05-05',
                'updated_at' => '2025-08-05',
            ],
        ];

        foreach ($ports as $port) {
            Port::create($port);
        }
    }
}
