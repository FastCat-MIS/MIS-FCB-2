<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            RolePermissionTableSeeder::class,
            UsersTableSeeder::class,
            AssignRolesSeeder::class,
            PortSeeder::class,               // Ports first
            RoutesTableSeeder::class,        // Routes next (depends on ports)
            SchedulesTableSeeder::class,     // Schedules last (depends on routes)
            PassengerTypesTableSeeder::class,
            PassengerCategoriesTableSeeder::class,
            PassengerAccommodationSeeder::class,
            VehicleGroupsTableSeeder::class,
            VehicleTypesTableSeeder::class,
            VehicleBrandsTableSeeder::class,
            InstitutionalAccountsTableSeeder::class,
        ]);

    }
}
