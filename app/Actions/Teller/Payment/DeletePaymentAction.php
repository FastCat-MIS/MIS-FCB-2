<?php

namespace App\Actions\Teller\Payment;

use App\Models\Teller\BookingPayment;

class DeletePaymentAction
{
    public function execute(int $paymentId)
    {
        $payment = BookingPayment::find($paymentId);

        if (!$payment) {
            throw new \Exception("Payment with ID {$paymentId} not found.");
        }

        $payment->delete();

        return response()->noContent();
    }
}