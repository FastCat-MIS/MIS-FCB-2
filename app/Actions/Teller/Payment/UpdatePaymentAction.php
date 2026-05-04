<?php

namespace App\Actions\Teller\Payment;

use App\Models\Teller\BookingPayment;

class UpdatePaymentAction
{
    public function execute(int $paymentId, array $data)
    {
        $payment = BookingPayment::find($paymentId);

        if (!$payment) {
            throw new \Exception("Payment with ID {$paymentId} not found.");
        }

        $payment->update($data);

        return $payment;
    }
}