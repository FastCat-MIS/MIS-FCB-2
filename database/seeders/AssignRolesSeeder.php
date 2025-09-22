<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accounts\User;
use Spatie\Permission\Models\Role;

class AssignRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Assign roles to users - use 'web' guard instead of 'api'
        $tellerRole = Role::findByName('Teller', 'api');
        $opManagerRole = Role::findByName('Operation Manager', 'api');
        $customerRole = Role::findByName('Customer', 'api');

        // Assign roles based on email
        $tovvy = User::where('email', 'tovvy@example.com')->first();
        $sean = User::where('email', 'sean@example.com')->first();
        $laurence = User::where('email', 'laurence@example.com')->first();
        $godadmin = User::where('email', 'godadmin@example.com')->first();
        $customer = User::where('email', 'customer@example.com')->first();

        if ($tovvy) $tovvy->assignRole($tellerRole);
        if ($sean) $sean->assignRole($tellerRole);
        if ($laurence) $laurence->assignRole($tellerRole);
        if ($godadmin) $godadmin->assignRole($opManagerRole);
        if ($customer) $customer->assignRole($customerRole);

        $this->command->info('Roles assigned to users successfully!');
    }
}
