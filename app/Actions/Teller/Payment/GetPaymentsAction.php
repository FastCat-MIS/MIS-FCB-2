<?php

namespace App\Actions\Teller\Payment;

use App\Actions\Action;
use App\Models\Teller\BookingPayment;
use App\Models\Teller\Booking;

class GetPaymentsAction extends Action
{
    public function execute()
    {
        $payments = BookingPayment::with([
            'bookedPassengers', 
            'bookedVehicles.driver'
        ])
            ->latest('booking_payment_id')
            ->get();

        // Manually load creator info from main database
        $userIds = $payments->pluck('created_by')->unique()->filter();
        if ($userIds->isNotEmpty()) {
            $users = \App\Models\Accounts\User::whereIn('id', $userIds)
                ->get(['id', 'first_name', 'middle_name', 'last_name', 'email'])
                ->keyBy('id');
            
            $payments->each(function ($payment) use ($users) {
                $payment->creator = $users->get($payment->created_by);
            });
        }

        // Manually load booking info (schedule/route snapshots)
        $bookingIds = $payments->pluck('booking_id')->unique()->filter();
        if ($bookingIds->isNotEmpty()) {
            $bookings = Booking::whereIn('booking_id', $bookingIds)->get()->keyBy('booking_id');
            
            $payments->each(function ($payment) use ($bookings) {
                $payment->booking = $bookings->get($payment->booking_id);
            });
        }

        return $this->success([
            'payments' => $payments,
        ], 'Payments retrieved successfully');
    }
}
