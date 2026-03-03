<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class InstitutionalAccountsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('institutional_accounts')->insert([
            [
                'ia_name' => 'ABC Travel Corporation',
                'image' => null,
                'address' => '123 Makati Avenue, Makati City',
                'email' => 'abc@travelcorp.com',
                'password' => Hash::make('password123'),
                'contact_number' => '+639171234567',
                'contact_person' => 'Juan Dela Cruz',
                'area' => 'Metro Manila',
                'mode_of_payment' => 'Bank Transfer',
                'type_of_payment' => 'Credit',
                'status' => 'active',
                'effective_date' => Carbon::now(),
                'eoc_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ia_name' => 'XYZ Corporate Services',
                'image' => null,
                'address' => '45 IT Park, Cebu City',
                'email' => 'xyz@corporate.com',
                'password' => Hash::make('password123'),
                'contact_number' => '+639189876543',
                'contact_person' => 'Maria Santos',
                'area' => 'Cebu',
                'mode_of_payment' => 'Cash',
                'type_of_payment' => 'Prepaid',
                'status' => 'active',
                'effective_date' => Carbon::now()->subDays(10),
                'eoc_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}