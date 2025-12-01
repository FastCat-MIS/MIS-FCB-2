<?php

namespace App\Actions\Operations\Booking;

use App\Actions\Action;
use App\Models\Operations\Booking;
use RuntimeException;

class GetBookingByKeywordAction extends Action
{
    /**
     * Execute keyword search on bookings table and return all matches.
     *
     * @param string $keyword
     * @return array
     */
    public function execute(string $keyword)
    {
        try {
            $bookings = Booking::with('schedule') // only eager load schedule
                ->where('booking_number', 'like', "%{$keyword}%")
                ->orWhereHas('schedule', function ($query) use ($keyword) {
                    $query->where('sched_id', $keyword);
                })
                ->orWhere('plate_number', 'like', "%{$keyword}%")
                ->get();

            if ($bookings->isEmpty()) {
                return $this->error('No bookings found matching the keyword.', 404);
            }

            return $this->success([
                'bookings' => $bookings
            ], 'Bookings retrieved successfully');
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve bookings: ' . $e->getMessage());
        }
    }
}
