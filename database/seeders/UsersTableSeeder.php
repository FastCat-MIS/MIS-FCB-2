<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accounts\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Tovvy',
                'middle_name' => 'M', // Added middle name
                'last_name' => 'Dumaplin',
                'email' => 'tovvy@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+1234567890',
                'address' => '123 Main St',
                'status' => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Sean',
                'middle_name' => 'Patrick', // Added middle name
                'last_name' => 'Patron',
                'email' => 'sean@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+1234567891',
                'address' => '456 Oak St',
                'status' => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Laurence',
                'middle_name' => 'James', // Added middle name
                'last_name' => 'Baylon',
                'email' => 'laurence@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+1234567892',
                'address' => '789 Pine St',
                'status' => 'active',
                'email_verified_at' => now(),
            ],
            // God Admin user
            [
                'first_name' => 'System',
                'middle_name' => 'Admin', // Added middle name
                'last_name' => 'Administrator',
                'email' => 'godadmin@example.com',
                'password' => Hash::make('godadmin123'),
                'phone' => '+1000000000',
                'address' => 'System Headquarters',
                'status' => 'active',
                'email_verified_at' => now(),
            ],
            // Customer user
            [
                'first_name' => 'John',
                'middle_name' => 'Michael', // Added middle name
                'last_name' => 'Customer',
                'email' => 'customer@example.com',
                'password' => Hash::make('customer123'),
                'phone' => '+1234567899',
                'address' => 'Customer Street',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
        }

        $this->command->info('Users seeded successfully!');
    }
}
