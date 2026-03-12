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
                'discount_name' => 'Senior Citizen',
                'discount_code' => 'SC20',
                'discount_value' => 20.00,
                'discount_type' => 'percentage',
                'effective_date' => null,
                'end_date' => null,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discount_name' => 'Student',
                'discount_code' => 'STUD10',
                'discount_value' => 10.00,
                'discount_type' => 'percentage',
                'effective_date' => null,
                'end_date' => null,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discount_name' => 'Person With Disability',
                'discount_code' => 'PWD500',
                'discount_value' => 500,
                'discount_type' => 'fixed',
                'effective_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonth(),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}