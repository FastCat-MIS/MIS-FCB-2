<?php

namespace App\Actions\Teller\Booking;

use App\Actions\Action;
use App\Models\Teller\TempBooking;

class GetBookingsAction extends Action
{
    public function execute(array $filters = [])
    {
        // Don't eager load - just get basic booking info for fast listing
        $query = TempBooking::query();

        // Optional filters
        if (isset($filters['serial_no'])) {
            $query->where('serial_no', $filters['serial_no']);
        }

        if (isset($filters['schedule_id'])) {
            $query->where('schedule_id', $filters['schedule_id']);
        }

        if (isset($filters['travel_date'])) {
            $query->where('travel_date', $filters['travel_date']);
        }

        if (isset($filters['created_by'])) {
            $query->where('created_by', $filters['created_by']);
        }

        $bookings = $query->orderBy('created_at', 'desc')
            ->get(['temp_booking_id', 'serial_no', 'travel_date', 'schedule_id', 'route_snapshot', 'vessel_snapshot', 'created_at']);

        return $this->success([
            'bookings' => $bookings,
            'total' => $bookings->count(),
        ], 'Bookings retrieved successfully');
    }
}
