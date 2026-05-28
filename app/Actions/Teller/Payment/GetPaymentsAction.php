<?php

namespace App\Actions\Teller\Payment;

use App\Actions\Action;
use App\Models\Teller\BookingPayment;
use App\Models\Teller\Booking;

class GetPaymentsAction extends Action
{
    public function execute(array $filters = [])
    {
        // Don't eager load - just get basic payment info for fast listing
        $query = BookingPayment::query();

        // Optional filters
        if (isset($filters['reference_number'])) {
            $query->where('reference_number', $filters['reference_number']);
        }

        if (isset($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }

        if (isset($filters['created_by'])) {
            $query->where('created_by', $filters['created_by']);
        }

        // Get only essential fields for listing
        $payments = $query->latest('booking_payment_id')
            ->get(['booking_payment_id', 'booking_id', 'reference_number', 'payment_method', 'grand_total', 'created_at']);

        // Load basic booking info (booking_number, route, vessel, travel_date, schedule)
        $bookingIds = $payments->pluck('booking_id')->unique()->filter();
        if ($bookingIds->isNotEmpty()) {
            $bookings = Booking::whereIn('booking_id', $bookingIds)
                ->get(['booking_id', 'booking_number', 'schedule_id', 'schedule_snapshot', 'travel_date', 'route_snapshot', 'vessel_snapshot'])
                ->keyBy('booking_id');
            
            // Get all unique schedule IDs to load from main database
            $scheduleIds = $bookings->pluck('schedule_id')->unique()->filter();
            $schedules = [];
            
            if ($scheduleIds->isNotEmpty()) {
                $schedules = \App\Models\Operations\Schedule::whereIn('sched_id', $scheduleIds)
                    ->get(['sched_id', 'departure_time', 'arrival_time', 'status'])
                    ->keyBy('sched_id');
            }
            
            $payments->each(function ($payment) use ($bookings, $schedules) {
                $booking = $bookings->get($payment->booking_id);
                if ($booking) {
                    $payment->booking_number = $booking->booking_number;
                    $payment->travel_date = $booking->travel_date;
                    $payment->route_snapshot = $booking->route_snapshot;
                    $payment->vessel_snapshot = $booking->vessel_snapshot;
                    
                    // Add full schedule details
                    if ($booking->schedule_id && isset($schedules[$booking->schedule_id])) {
                        $schedule = $schedules[$booking->schedule_id];
                        $payment->schedule = [
                            'schedule_id' => $schedule->sched_id,
                            'departure_time' => $schedule->departure_time,
                            'arrival_time' => $schedule->arrival_time,
                            'status' => $schedule->status,
                        ];
                    }
                }
            });
        }

        return $this->success([
            'bookings' => $payments,
            'total' => $payments->count(),
        ], 'Completed bookings retrieved successfully');
    }
}
