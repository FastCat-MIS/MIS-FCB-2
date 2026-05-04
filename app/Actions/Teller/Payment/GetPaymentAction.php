<?php

namespace App\Actions\Teller\Payment;

use App\Models\Teller\BookingPayment;

class GetPaymentAction
{
    public function execute(int $paymentId)
    {
        $payment = BookingPayment::with(['bookedPassengers', 'bookedVehicles'])->find($paymentId);

        if (!$payment) {
            throw new \Exception("Payment with ID {$paymentId} not found.");
        }

        return $payment;
    }
}
