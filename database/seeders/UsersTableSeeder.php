<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accounts\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $vesselMasterRoleId = Role::where('name', 'Vessel Master')->where('guard_name', 'api')->value('id');

        $users = [
            [
                'first_name' => 'Tovvy',
                'middle_name' => 'M',
                'last_name' => 'Dumaplin',
                'email' => 'tovvy@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+1234567890',
                'address' => '123 Main St',
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Sean',
                'middle_name' => 'Patrick',
                'last_name' => 'Patron',
                'email' => 'sean@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+1234567891',
                'address' => '456 Oak St',
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Laurence',
                'middle_name' => 'James',
                'last_name' => 'Baylon',
                'email' => 'laurence@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+1234567892',
                'address' => '789 Pine St',
                'status' => true,
                'email_verified_at' => now(),
            ],
            // God Admin user
            [
                'first_name' => 'System',
                'middle_name' => 'Admin',
                'last_name' => 'Administrator',
                'email' => 'godadmin@example.com',
                'password' => Hash::make('godadmin123'),
                'phone' => '+1000000000',
                'address' => 'System Headquarters',
                'status' => true,
                'email_verified_at' => now(),
            ],
            // Customer user
            [
                'first_name' => 'John',
                'middle_name' => 'Michael',
                'last_name' => 'Customer',
                'email' => 'customer@example.com',
                'password' => Hash::make('customer123'),
                'phone' => '+1234567899',
                'address' => 'Customer Street',
                'status' => true,
                'email_verified_at' => now(),
            ],
            // Vessel Master users
            [
                'first_name' => 'Carlos',
                'middle_name' => 'Rey',
                'last_name' => 'Navarro',
                'email' => 'vesselmaster@example.com',
                'password' => Hash::make('vesselmaster123'),
                'phone' => '+1234567898',
                'address' => 'Port Headquarters',
                'role_id' => $vesselMasterRoleId,
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Ramon',
                'middle_name' => 'Cruz',
                'last_name' => 'Dela Torre',
                'email' => 'vesselmaster2@example.com',
                'password' => Hash::make('vesselmaster123'),
                'phone' => '+1234567897',
                'address' => 'Port Headquarters',
                'role_id' => $vesselMasterRoleId,
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Miguel',
                'middle_name' => 'Santos',
                'last_name' => 'Reyes',
                'email' => 'vesselmaster3@example.com',
                'password' => Hash::make('vesselmaster123'),
                'phone' => '+1234567896',
                'address' => 'Port Headquarters',
                'role_id' => $vesselMasterRoleId,
                'status' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        $this->command->info('Users seeded successfully!');
    }
}
