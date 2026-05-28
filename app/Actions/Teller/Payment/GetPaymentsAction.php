<?php

namespace App\Actions\Teller\Payment;

use App\Actions\Action;
use App\Models\Teller\BookingPayment;
use App\Models\Teller\Booking;

class GetPaymentsAction extends Action
{
    /**
     * Retrieve list of completed bookings with payment information
     * 
     * Returns a paginated list of all completed bookings. Uses manual bulk loading
     * instead of eager loading to optimize performance for large result sets.
     * Includes schedule details from the main database.
     * 
     * @param array $filters Optional filters (reference_number, payment_method, created_by)
     * @return array Success response with bookings array and total count
     */
    public function execute(array $filters = [])
    {
        // Query only essential fields for fast listing - don't eager load relationships
        $query = BookingPayment::query();

        // Apply optional filters if provided
        if (isset($filters['reference_number'])) {
            $query->where('reference_number', $filters['reference_number']);
        }

        if (isset($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }

        if (isset($filters['created_by'])) {
            $query->where('created_by', $filters['created_by']);
        }

        // Retrieve payments with only essential columns for listing performance
        $payments = $query->latest('booking_payment_id')
            ->get(['booking_payment_id', 'booking_id', 'reference_number', 'payment_method', 'grand_total', 'created_at']);

        // Manually bulk load booking information to avoid N+1 queries
        $bookingIds = $payments->pluck('booking_id')->unique()->filter();
        if ($bookingIds->isNotEmpty()) {
            $bookings = Booking::whereIn('booking_id', $bookingIds)
                ->get(['booking_id', 'booking_number', 'schedule_id', 'schedule_snapshot', 'travel_date', 'route_snapshot', 'vessel_snapshot'])
                ->keyBy('booking_id');
            
            // Load schedule details from main database in bulk
            $scheduleIds = $bookings->pluck('schedule_id')->unique()->filter();
            $schedules = [];
            
            if ($scheduleIds->isNotEmpty()) {
                $schedules = \App\Models\Operations\Schedule::whereIn('sched_id', $scheduleIds)
                    ->get(['sched_id', 'departure_time', 'arrival_time', 'status'])
                    ->keyBy('sched_id');
            }
            
            // Attach booking and schedule data to each payment record
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
