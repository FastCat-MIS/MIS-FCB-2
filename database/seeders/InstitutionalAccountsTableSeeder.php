<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marketing\InstitutionalAccount;

class InstitutionalAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['ia_name' => 'Philtranco', 'ia_image' => file_get_contents(database_path('seeders/images/philtranco.jpg'))],
            ['ia_name' => '888 Fasteasy Inc.', 'ia_image' => file_get_contents(database_path('seeders/images/888fasteasy.jpg'))],
            ['ia_name' => 'Airspeed Int.', 'ia_image' => file_get_contents(database_path('seeders/images/airspeed.jpg'))],
        ];

        foreach ($accounts as $account) {
            InstitutionalAccount::updateOrCreate(['ia_name' => $account['ia_name']], $account);
        }
    }
}
