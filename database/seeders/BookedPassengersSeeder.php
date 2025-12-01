<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\BookedPassenger;
use App\Models\Operations\Booking;
use App\Models\Marketing\Discount;
use App\Models\Operations\PassengerAccommodation;

class BookedPassengersSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = Booking::all();
        $discounts = Discount::all();
        $accommodations = PassengerAccommodation::all();

        if ($bookings->isEmpty()) {
            $this->command->warn('No bookings found. Seed bookings first.');
            return;
        }

        $passengerIndex = 1;

        foreach ($bookings as $booking) {
            for ($i = 1; $i <= 2; $i++) { // 2 passengers per booking
                $discount = $discounts->random() ?? null;
                $accommodation = $accommodations->random() ?? null;

                $discountPercentage = $discount ? $discount->discount_percentage : 0;
                $baseAmount = 500 + ($i * 50);
                $amount = $baseAmount - ($baseAmount * $discountPercentage / 100);

                BookedPassenger::create([
                    'booking_id' => $booking->booking_id,
                    'fullname' => 'Passenger ' . $passengerIndex,
                    'discount_id' => $discount ? $discount->discount_id : null,
                    'amount' => $amount,
                    'vehicle_amount' => $i % 2 == 0 ? 200 : null,
                    'category' => $i == 1 ? 'Adult' : 'Child',
                    'type' => 'Regular',
                    'accommodation_id' => $accommodation ? $accommodation->accommodation_id : null,
                    'gender' => $i % 2 == 0 ? 'Male' : 'Female',
                    'seat' => chr(64 + $i) . $i, // A1, B2...
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $passengerIndex++;
            }
        }

        $this->command->info('Booked passengers seeded successfully.');
    }
}
