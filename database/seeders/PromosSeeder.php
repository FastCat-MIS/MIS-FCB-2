<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('promos')->insert([
            [
                'promo_name' => 'Winter Promo',
                'promo_code' => 'WP50',
                'promo_value' => 50,
                'promo_type' => 'percentage',
                'effective_date' => null,
                'end_date' => null,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'promo_name' => 'Graduation Promo',
                'promo_code' => 'GP20',
                'promo_value' => 20.00,
                'promo_type' => 'percentage',
                'effective_date' => null,
                'end_date' => null,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'promo_name' => 'Holiday Promo',
                'promo_code' => 'HOLIDAY500',
                'promo_value' => 500,
                'promo_type' => 'fixed',
                'effective_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonth(),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}