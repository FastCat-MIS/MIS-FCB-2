<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        // Get roles
        $teller = Role::findByName('Teller', 'api');
        $opAssistant = Role::findByName('Operation Assistant', 'api');
        $opSupervisor = Role::findByName('Operation Supervisor', 'api');
        $opManager = Role::findByName('Operation Manager', 'api');
        $tellerSupervisor = Role::findByName('Teller Supervisor', 'api');

        // Get permissions
        $seatRead = Permission::findByName('seat management read', 'api');
        $bookingCreate = Permission::findByName('booking create', 'api');
        $bookingRead = Permission::findByName('booking read', 'api');
        $bookingUpdate = Permission::findByName('booking update', 'api');
        $scheduleCreate = Permission::findByName('schedule management create', 'api');
        $scheduleRead = Permission::findByName('schedule management read', 'api');

        // Assign permissions to roles
        $teller->syncPermissions([$seatRead, $bookingCreate, $bookingRead, $bookingUpdate]);
        $opAssistant->syncPermissions([$scheduleCreate, $scheduleRead]);
        $opSupervisor->syncPermissions([$scheduleCreate, $scheduleRead, $bookingRead]);
        $opManager->syncPermissions(Permission::all()); // Full access
        $tellerSupervisor->syncPermissions([$seatRead, $bookingCreate, $bookingRead, $bookingUpdate, $scheduleRead]);

        $this->command->info('Role permissions seeded successfully!');
    }
}
