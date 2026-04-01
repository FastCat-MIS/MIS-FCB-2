<?php

namespace Database\Seeders;

use App\Models\Marketing\Discounts\MerchantDiscount;
use Illuminate\Database\Seeder;
use App\Models\Marketing\Merchant;
use App\Models\Operations\Route;
use Illuminate\Support\Carbon;

class MerchantDiscountsSeeder extends Seeder
{
    public function run(): void
    {
        $merchants = Merchant::all();
        $routes = Route::all();

        foreach ($merchants as $merchant) {
            foreach ($routes as $route) {

                MerchantDiscount::create([
                    'merchant_id' => $merchant->merchant_id,
                    'route_id' => $route->route_id,
                    'discount_name' => 'Standard Discount',
                    'discount_value' => rand(5, 20),
                    'value_type' => 1, 
                    'effective_date' => Carbon::now(),
                    'status' => 1,
                ]);
            }
        }
    }
}