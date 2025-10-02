<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\PassengerAccommodation;

class PassengerAccommodationSeeder extends Seeder
{
    public function run(): void
    {
        $accommodations = [
            ['accommodation_name' => 'Business Class'],
            ['accommodation_name' => 'Premium Economy'],
            ['accommodation_name' => 'Economy'],
        ];

        foreach ($accommodations as $item) {
            PassengerAccommodation::firstOrCreate($item);
        }
    }
}
