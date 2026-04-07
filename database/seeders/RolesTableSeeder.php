<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Teller', 'guard_name' => 'api'],
            ['name' => 'Operation Assistant', 'guard_name' => 'api'],
            ['name' => 'Operation Supervisor', 'guard_name' => 'api'],
            ['name' => 'Operation Manager', 'guard_name' => 'api'],
            ['name' => 'Teller Supervisor', 'guard_name' => 'api'],
            ['name' => 'Customer', 'guard_name' => 'api'],
            ['name' => 'Vessel Master', 'guard_name' => 'api'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['guard_name' => $role['guard_name']]
            );
        }

        $this->command->info('Roles seeded successfully!');
    }
}
