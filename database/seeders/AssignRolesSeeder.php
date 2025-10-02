<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accounts\User;
use Spatie\Permission\Models\Role;

class AssignRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Use 'api' guard since this is an API-only app
        $roles = [
            'Teller'             => ['tovvy@example.com', 'sean@example.com', 'laurence@example.com'],
            'Operation Manager'  => ['godadmin@example.com'],
            'Customer'           => ['customer@example.com'],
        ];

        foreach ($roles as $roleName => $emails) {
            $role = Role::where('name', $roleName)->where('guard_name', 'api')->first();

            if (!$role) {
                $this->command->warn("⚠️  Role '{$roleName}' not found with guard 'api'. Skipping.");
                continue;
            }

            foreach ($emails as $email) {
                $user = User::where('email', $email)->first();

                if (!$user) {
                    $this->command->warn("⚠️  User with email '{$email}' not found. Skipping.");
                    continue;
                }

                $user->assignRole($role);
                $this->command->info("✅ Assigned '{$roleName}' role to {$email}");
            }
        }

        $this->command->info('🎉 All available roles assigned to users successfully!');
    }
}
