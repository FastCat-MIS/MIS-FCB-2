<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marketing\AddOn; 

class AddOnsSeeder extends Seeder
{
    public function run(): void
    {
        $addOns = [
            ['add_on_name' => 'Add On 1', "value" => 200, "value_type" => 1, "operator" => 0 ],
            ['add_on_name' => 'Add On 2', "value" => 2400, "value_type" => 0, "operator" => 1],
            ['add_on_name' => 'Add On 3', "value" => 2500, "value_type" => 1, "operator" => 1],  
            ['add_on_name' => 'Add On 4', "value" => 2600, "value_type" => 0, "operator" => 0],
        ];

        foreach ($addOns as $addOn) {
            AddOn::updateOrCreate(['add_on_name' => $addOn['add_on_name']], $addOn);
        }

        $this->command->info(count($addOns) . ' add-ons seeded successfully.');         
    }
}