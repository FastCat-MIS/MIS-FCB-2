<?php

namespace App\Actions\Teller\Ticket;

use App\Actions\Action;
use App\Models\Teller\Booking;
use App\Models\Operations\Schedule;

class GenerateTicketAction extends Action
{
    public function execute(string $bookingNumber)
    {
        // Fetch booking with relationships
        $booking = Booking::with(['passengers', 'vehicles', 'payment'])
            ->where('booking_number', $bookingNumber)
            ->first();

        if (!$booking) {
            return $this->error(null, 'Booking not found', 404);
        }

        // Get schedule details
        $schedule = Schedule::find($booking->schedule_id);

        if (!$schedule) {
            return $this->error(null, 'Schedule not found', 404);
        }

        // Prepare ticket data for each passenger
        $tickets = [];
        foreach ($booking->passengers as $passenger) {
            // Calculate discount percentage
            $discountPercentage = 0;
            if ($passenger->fare > 0) {
                $discountPercentage = ($passenger->discount_amount / $passenger->fare) * 100;
            }

            // Get vehicle info if passenger is a driver
            $vehicle = $booking->vehicles->firstWhere('driver_passenger_booking_id', $passenger->booked_passenger_id);

            // Parse passenger category snapshot for accommodation
            $passengerCategory = $passenger->passenger_category_snapshot;
            
            $accommodation = $passengerCategory['category_name'] ?? 'N/A';

            // Generate QR code data
            $qrData = implode(',', [
                $booking->travel_date->format('Y-m-d'),
                $schedule->departure_time,
                $schedule->port_id,
                $schedule->sched_id,
                $booking->booking_number,
                $passenger->fullname,
                $accommodation,
                $passenger->seat_number_snapshot ?? 'N/A',
                $booking->booking_origin ?? ''
            ]);

            $tickets[] = [
                'booking_number' => $booking->booking_number,
                'travel_date' => $booking->travel_date,
                'departure_time' => $schedule->departure_time,
                'fullname' => $passenger->fullname,
                'accommodation' => $accommodation,
                'seat_number' => $passenger->seat_number_snapshot ?? 'N/A',
                'discount' => round($discountPercentage, 2),
                'amount' => number_format($booking->payment->grand_total ?? 0, 2),
                'vehicle_type' => $vehicle->vehicle_type ?? null,
                'plate_number' => $vehicle->plate_no ?? null,
                'qr_data' => urlencode($qrData),
            ];
        }

        // Return view with tickets data
        return view('tickets.generate', ['tickets' => $tickets]);
    }
}
