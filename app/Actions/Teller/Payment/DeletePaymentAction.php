<?php

namespace App\Actions\Teller\Payment;

use App\Models\Teller\BookingPayment;

class DeletePaymentAction
{
    public function execute(int $paymentId)
    {
        // Validate ID is provided and valid
        if ($paymentId <= 0) {
            throw new \Exception('Invalid payment ID provided. Please provide a valid booking_payment_id in the URL: DELETE /teller-booking/payment/{id}');
        }

        $payment = BookingPayment::find($paymentId);

        if (!$payment) {
            throw new \Exception("Payment with ID {$paymentId} not found.");
        }

        $payment->delete();

        return response()->noContent();
    }
}