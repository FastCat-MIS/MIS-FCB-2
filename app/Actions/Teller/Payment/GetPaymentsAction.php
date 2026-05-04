<?php

namespace App\Actions\Teller\Payment;

use App\Models\Teller\BookingPayment;

class GetPaymentsAction
{
    public function execute()
    {
        return BookingPayment::with(['bookedPassengers', 'bookedVehicles'])->get();
    }
}
