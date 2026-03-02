<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiscountsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('discounts')->insert([
            [
                'discount_type' => 'Senior Citizen',
                'discount_code' => 'SC20',
                'discount_percentage' => 20.00,
                'start_date' => null,
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discount_type' => 'Student',
                'discount_code' => 'STUD10',
                'discount_percentage' => 10.00,
                'start_date' => null,
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discount_type' => 'Holiday Promo',
                'discount_code' => 'HOLIDAY15',
                'discount_percentage' => 15.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonth(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}