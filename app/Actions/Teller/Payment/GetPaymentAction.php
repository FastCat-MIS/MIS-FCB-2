<?php

namespace App\Actions\Teller\Payment;

use App\Actions\Action;
use App\Models\Teller\BookingPayment;
use App\Models\Teller\Booking;

class GetPaymentAction extends Action
{
    public function execute(int $paymentId)
    {
        $payment = BookingPayment::with([
            'bookedPassengers', 
            'bookedVehicles.driver'
        ])->find($paymentId);

        if (!$payment) {
            return $this->error("Payment with ID {$paymentId} not found.", 404);
        }

        // Manually load creator info from main database
        if ($payment->created_by) {
            $payment->creator = \App\Models\Accounts\User::find($payment->created_by, ['id', 'first_name', 'middle_name', 'last_name', 'email']);
        }

        // Manually load booking info with passengers and vehicles
        if ($payment->booking_id) {
            $payment->booking = Booking::with(['passengers', 'vehicles.driver'])
                ->find($payment->booking_id);
        }

        return $this->success([
            'payment' => $payment,
        ], 'Payment retrieved successfully');
    }
}
