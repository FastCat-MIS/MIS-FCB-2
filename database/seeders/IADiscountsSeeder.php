<?php

namespace Database\Seeders;

use App\Models\Marketing\Discounts\IADiscount;
use Illuminate\Database\Seeder;
use App\Models\Marketing\InstitutionalAccount;
use App\Models\Operations\Route;
use Illuminate\Support\Carbon;

class IADiscountsSeeder extends Seeder
{
    public function run(): void
    {
        $institutionalAccounts = InstitutionalAccount::all();
        $routes = Route::all();

        foreach ($institutionalAccounts as $ia) {
            foreach ($routes as $route) {

                IADiscount::create([
                    'ia_id' => $ia->ia_id,
                    'route_id' => $route->route_id,
                    'discount_name' => 'Standard Discount',
                    'discount_value' => rand(5, 20),
                    'value_type' => 1, 
                    'effective_date' => Carbon::now(),
                    'status' => 'active',
                ]);

            }
        }
    }
}