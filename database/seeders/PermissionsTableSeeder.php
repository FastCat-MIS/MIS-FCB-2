<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Schedule Management
            ['name' => 'schedule management create', 'guard_name' => 'api'],
            ['name' => 'schedule management read', 'guard_name' => 'api'],
            ['name' => 'schedule management update', 'guard_name' => 'api'],
            ['name' => 'schedule management delete', 'guard_name' => 'api'],

            // Seat Management
            ['name' => 'seat management create', 'guard_name' => 'api'],
            ['name' => 'seat management read', 'guard_name' => 'api'],
            ['name' => 'seat management update', 'guard_name' => 'api'],
            ['name' => 'seat management delete', 'guard_name' => 'api'],

            // Booking
            ['name' => 'booking create', 'guard_name' => 'api'],
            ['name' => 'booking read', 'guard_name' => 'api'],
            ['name' => 'booking update', 'guard_name' => 'api'],
            ['name' => 'booking delete', 'guard_name' => 'api'],

            // User Management
            ['name' => 'user management create', 'guard_name' => 'api'],
            ['name' => 'user management read', 'guard_name' => 'api'],
            ['name' => 'user management update', 'guard_name' => 'api'],
            ['name' => 'user management delete', 'guard_name' => 'api'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['guard_name' => $permission['guard_name']]
            );
        }

        $this->command->info('Permissions seeded successfully!');
    }
}
