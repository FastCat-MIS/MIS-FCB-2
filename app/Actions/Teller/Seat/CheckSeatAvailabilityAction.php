<?php

namespace App\Actions\Teller\Seat;

use App\Actions\Action;
use App\Models\Teller\ScheduleSeatLock;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CheckSeatAvailabilityAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'schedule_id' => 'required|integer|min:1',
            'seat_id' => 'required|integer|min:1',
            'travel_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        // Check if seat has any lock (temp or permanent)
        $lock = ScheduleSeatLock::where('schedule_id', $validated['schedule_id'])
            ->where('seat_id', $validated['seat_id'])
            ->where('travel_date', $validated['travel_date'])
            ->first();

        if ($lock) {
            // Check if it's a permanent lock (booked)
            if ($lock->expires_at === null) {
                return $this->success([
                    'available' => false,
                    'status' => 'booked',
                    'reason' => 'Seat already permanently booked',
                    'booking_info' => [
                        'booking_number' => $lock->serial_no,  // After payment, serial_no contains booking_number
                        'locked_by_type' => $lock->locked_by_type,
                        'booked_at' => $lock->locked_at,
                    ],
                ], 'Seat is already booked');
            }

            // Check if it's an active temporary lock
            if ($lock->expires_at > now()) {
                return $this->success([
                    'available' => false,
                    'status' => 'locked',
                    'reason' => 'Seat temporarily locked by another booking',
                    'lock_info' => [
                        'serial_no' => $lock->serial_no,
                        'locked_by_type' => $lock->locked_by_type,
                        'locked_by_user_id' => $lock->locked_by_user_id,
                        'expires_at' => $lock->expires_at,
                        'expires_in_minutes' => $lock->remaining_minutes,
                    ],
                ], 'Seat is currently locked');
            }

            // Lock has expired, seat is available
        }

        // Seat is available
        return $this->success([
            'available' => true,
            'status' => 'available',
            'reason' => null,
        ], 'Seat is available');
    }
}
