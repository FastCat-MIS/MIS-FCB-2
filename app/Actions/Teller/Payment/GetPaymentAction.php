<?php

namespace App\Actions\Teller\Payment;

use App\Actions\Action;
use App\Models\Teller\BookingPayment;
use App\Models\Teller\Booking;

class GetPaymentAction extends Action
{
    /**
     * Retrieve detailed information for a single completed booking
     * 
     * Returns complete payment details including all passengers, vehicles,
     * driver information, and schedule details. Used for viewing full
     * booking information after payment is completed.
     * 
     * @param int $paymentId The booking_payment_id to retrieve
     * @return array Success response with full payment details or error
     */
    public function execute(int $paymentId)
    {
        // Validate that a positive payment ID was provided
        if ($paymentId <= 0) {
            return $this->error('Invalid payment ID provided. Please provide a valid booking_payment_id in the URL: GET /teller-booking/payment/{id}', 400);
        }

        // Load payment with all related passengers and vehicles (eager loading to avoid N+1)
        $payment = BookingPayment::with([
            'bookedPassengers', 
            'bookedVehicles.driver'
        ])->find($paymentId);

        if (!$payment) {
            return $this->error("Payment with ID {$paymentId} not found.", 404);
        }

        // Load user information from main database for the creator
        if ($payment->created_by) {
            $payment->creator = \App\Models\Accounts\User::find($payment->created_by, ['id', 'first_name', 'middle_name', 'last_name', 'email']);
        }

        // Load complete booking information with all passengers and vehicles
        if ($payment->booking_id) {
            $payment->booking = Booking::with(['passengers', 'vehicles.driver'])
                ->find($payment->booking_id);
            
            // Load schedule details from main database
            if ($payment->booking && $payment->booking->schedule_id) {
                $schedule = \App\Models\Operations\Schedule::where('sched_id', $payment->booking->schedule_id)
                    ->first();
                
                if ($schedule) {
                    $payment->schedule = [
                        'schedule_id' => $schedule->sched_id,
                        'departure_time' => $schedule->departure_time,
                        'arrival_time' => $schedule->arrival_time,
                        'status' => $schedule->status,
                    ];
                }
            }
        }

        return $this->success([
            'payment' => $payment,
        ], 'Payment retrieved successfully');
    }
}
