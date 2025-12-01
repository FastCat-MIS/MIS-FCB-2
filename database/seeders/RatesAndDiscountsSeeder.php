<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marketing\Rate;
use App\Models\Marketing\Discount;
use App\Models\Operations\Route;

class RatesAndDiscountsSeeder extends Seeder
{
    public function run(): void
    {
        // --- SEED RATES ---
        $seatClasses = [
            'Economy' => 500,
            'Premium Economy' => 750,
            'Business Class' => 1200,
        ];

        $routes = Route::all();

        if ($routes->isEmpty()) {
            $this->command->warn('No routes found. Please seed routes first.');
        } else {
            $rates = [];

            foreach ($routes as $route) {
                foreach ($seatClasses as $seatClass => $baseRate) {
                    $rates[] = [
                        'route_id' => $route->route_id,
                        'seat_class' => $seatClass,
                        'base_rate' => $baseRate,
                        'status' => 'active',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            foreach ($rates as $rate) {
                Rate::create($rate);
            }

            $this->command->info(count($rates) . ' rates seeded successfully.');
        }

        // --- SEED DISCOUNTS ---
        $discounts = [
            [
                'discount_type' => 'Senior Citizen',
                'discount_code' => 'SC20',
                'discount_percentage' => 20,
                'start_date' => null,
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discount_type' => 'Student',
                'discount_code' => 'ST10',
                'discount_percentage' => 10,
                'start_date' => null,
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discount_type' => 'PWD',
                'discount_code' => 'PWD15',
                'discount_percentage' => 15,
                'start_date' => null,
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($discounts as $discount) {
            Discount::create($discount);
        }

        $this->command->info(count($discounts) . ' discounts seeded successfully.');
    }
}
