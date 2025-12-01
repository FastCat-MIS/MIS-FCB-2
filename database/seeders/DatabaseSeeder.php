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
            PortSeeder::class,
            RoutesTableSeeder::class,
            SchedulesTableSeeder::class,
            PassengerTypesTableSeeder::class,
            PassengerCategoriesTableSeeder::class,
            PassengerAccommodationSeeder::class,
            VehicleGroupsTableSeeder::class,
            VehicleTypesTableSeeder::class,
            VehicleBrandsTableSeeder::class,
            InstitutionalAccountsTableSeeder::class,
            RatesAndDiscountsSeeder::class,
            BookingsSeeder::class,
            BookedPassengersSeeder::class,
            ConnectingTripSeeder::class,
        ]);

    }
}
