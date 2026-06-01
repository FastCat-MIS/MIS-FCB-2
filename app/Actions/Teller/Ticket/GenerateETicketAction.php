<?php

namespace App\Actions\Teller\Ticket;

use App\Actions\Action;
use App\Models\Accounts\User;
use App\Models\Teller\Booking;
use App\Models\Operations\Schedule;

class GenerateETicketAction extends Action
{
    public function execute(string $bookingNumber)
    {
        $booking = Booking::with(['passengers', 'vehicles', 'payment'])
            ->where('booking_number', $bookingNumber)
            ->first();

        if (!$booking) {
            return $this->error(null, 'Booking not found', 404);
        }

        $schedule = Schedule::find($booking->schedule_id);

        if (!$schedule) {
            return $this->error(null, 'Schedule not found', 404);
        }

        $issuer = User::find($booking->created_by);
        $issuedBy = $issuer ? $issuer->full_name : '';

        $tickets = [];
        foreach ($booking->passengers as $passenger) {
            $discountPercentage = 0;
            if ($passenger->fare > 0) {
                $discountPercentage = ($passenger->discount_amount / $passenger->fare) * 100;
            }

            $accommodation = $this->cleanSnapshot($passenger->passenger_category_snapshot);
            $passengerType = $this->cleanSnapshot($passenger->passenger_type_snapshot);

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
                'booking_number'  => $booking->booking_number,
                'travel_date'     => $booking->travel_date,
                'departure_time'  => $schedule->departure_time,
                'fullname'        => $passenger->fullname,
                'accommodation'   => $accommodation,
                'passenger_type'  => $passengerType,
                'seat_number'     => $passenger->seat_number_snapshot ?? '',
                'id_number'       => '',
                'contact'         => '',
                'discount'        => round($discountPercentage, 2),
                'fare'            => number_format($passenger->fare ?? 0, 2),
                'convenience_fee' => number_format($passenger->convenience_fee ?? 2.00, 2),
                'amount'          => number_format($booking->payment->grand_total ?? 0, 2),
                'issued_by'       => $issuedBy,
                'qr_data'         => urlencode($qrData),
            ];
        }

        return view('etickets.generate', ['tickets' => $tickets]);
    }

    private function cleanSnapshot($value): string
    {
        if ($value === null || !is_string($value)) {
            return 'N/A';
        }

        $decoded = json_decode($value, true);
        return is_string($decoded) ? $decoded : $value;
    }
}
