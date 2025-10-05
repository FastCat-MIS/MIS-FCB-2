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
            RoutesTableSeeder::class,
            SchedulesTableSeeder::class,
            PassengerTypesTableSeeder::class,
            PassengerCategoriesTableSeeder::class,
            PassengerAccommodationSeeder::class,
            VehicleGroupsTableSeeder::class,
            VehicleTypesTableSeeder::class,
            VehicleBrandsTableSeeder::class,
            InstitutionalAccountsTableSeeder::class,
            // Add other seeders here as you create them
        ]);
    }
}
