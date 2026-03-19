<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiscountsSeeder extends Seeder
{
    public function run(): void
    {

        $now = Carbon::now();

        $yearHex = strtoupper(dechex($now->year));
        $monthHex = strtoupper(str_pad(dechex($now->month), STR_PAD_LEFT));

        $discounts = [
            [
                'discount_name' => 'Senior Citizen',
                'discount_code' => 'SC20',
                'discount_value' => 20.00,
                'value_type' => 0,
                'effective_date' => null,
                'end_date' => null,
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discount_name' => 'Student',
                'discount_code' => 'STUD10',
                'discount_value' => 10.00,
                'value_type' => 0,
                'effective_date' => null,
                'end_date' => null,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discount_name' => 'Person With Disability',
                'discount_code' => 'PWD500',
                'discount_value' => 500,
                'value_type' => 1,
                'effective_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonth(),
                'status' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
                        [
                'discount_name' => 'XYZ',
                'discount_code' => 'XYZ123',
                'discount_value' => 500,
                'value_type' => 1,
                'effective_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonth(),
                'status' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        foreach ($discounts as $index => $discount) {

            $decimal = str_pad($index, 2, '0', STR_PAD_LEFT);

            $discount['discount_cn'] = $yearHex . $monthHex . '-' . $decimal;
            $discount['created_at'] = now();
            $discount['updated_at'] = now();

            DB::table('discounts')->insert($discount);
        }
    }
}