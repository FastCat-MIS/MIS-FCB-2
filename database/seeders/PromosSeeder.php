<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromosSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $yearHex = strtoupper(dechex($now->year));
        $monthHex = strtoupper(str_pad(dechex($now->month), 2, '0', STR_PAD_LEFT));

        $promos = [
            [
                'promo_name' => 'Winter Promo',
                'promo_code' => 'WP50',
                'promo_value' => 50,
                'value_type' => 1,
                'effective_date' => null,
                'end_date' => null,
                'status' => 0,
            ],
            [
                'promo_name' => 'Graduation Promo',
                'promo_code' => 'GP20',
                'promo_value' => 20.00,
                'value_type' => 1,
                'effective_date' => null,
                'end_date' => null,
                'status' => 1,
            ],
            [
                'promo_name' => 'Holiday Promo',
                'promo_code' => 'HOLIDAY500',
                'promo_value' => 500,
                'value_type' => 0,
                'effective_date' => $now,
                'end_date' => $now->copy()->addMonth(),
                'status' => 2,
            ],
            [
                'promo_name' => 'XYZ Promo',
                'promo_code' => 'XYZ500',
                'promo_value' => 500,
                'value_type' => 1,
                'effective_date' => $now,
                'end_date' => $now->copy()->addMonth(),
                'status' => 3,
            ],
        ];

        foreach ($promos as $index => $promo) {

            $decimal = str_pad($index, 2, '0', STR_PAD_LEFT);

            $promo['promo_cn'] = $yearHex . $monthHex . '-' . $decimal;
            $promo['created_at'] = now();
            $promo['updated_at'] = now();

            DB::table('promos')->insert($promo);
        }
    }
}