<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MerchantsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('merchants')->insert([
            [
                'merchant_name' => 'Merchant ABC Agency',
                'image' => null,
                'address' => '123 Makati Avenue, Makati City',
                'email' => 'abc@travelcorp.com',
                'password' => Hash::make('password123'),
                'contact_number' => '+639171234567',
                'contact_person' => 'Juan Dela Cruz',
                'area' => 'Metro Manila',
                'payment_mode' => 'Prepaid',
                'payment_type' => 'Non-Fixed',
                'status' => 'active',
                'effective_date' => Carbon::now(),
                'eoc_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'merchant_name' => 'Merchant XYZ Agency',
                'image' => null,
                'address' => '45 IT Park, Cebu City',
                'email' => 'xyz@corporate.com',
                'password' => Hash::make('password123'),
                'contact_number' => '+639189876543',
                'contact_person' => 'Maria Santos',
                'area' => 'Cebu',
                'payment_mode' => 'Cash',
                'payment_type' => 'Fixed',
                'status' => 'active',
                'effective_date' => Carbon::now()->subDays(10),
                'eoc_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}