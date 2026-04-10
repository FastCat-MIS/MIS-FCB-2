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
            VesselSeeder::class,
            SchedulesTableSeeder::class,
            PassengerTypesTableSeeder::class,
            PassengerCategoriesTableSeeder::class,
            PassengerAccommodationSeeder::class,
            InstitutionalAccountsSeeder::class,
            DiscountsSeeder::class,
            BookingsSeeder::class,
            BookedPassengersSeeder::class,
            ConnectingTripSeeder::class,
            AddOnsSeeder::class,
            VehiclesSeeder::class,
            VehicleRatesSeeder::class,
            AccommodationRatesSeeder::class,
            IADiscountsSeeder::class,
            MerchantsSeeder::class,
            MerchantDiscountsSeeder::class,
            PromosSeeder::class,
            VdarSeeder::class,
            CancellationReportSeeder::class,
        ]);

    }
}
