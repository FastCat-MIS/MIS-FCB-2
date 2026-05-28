<?php

namespace App\Actions\Teller\Seat;

use App\Actions\Action;
use App\Models\Teller\ScheduleSeatLock;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GetBookedSeatsAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'schedule_id' => 'required|integer|min:1',
            'travel_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        // Get ALL seat locks for this schedule + date (both temp and permanent)
        $allLocks = ScheduleSeatLock::where('schedule_id', $validated['schedule_id'])
            ->where('travel_date', $validated['travel_date'])
            ->get();

        // Separate into temporary (locked) and permanent (booked)
        $temporaryLocks = $allLocks->filter(function($lock) {
            return $lock->expires_at !== null && $lock->expires_at > now();
        });

        $permanentLocks = $allLocks->filter(function($lock) {
            return $lock->expires_at === null;
        });

        // Format locked seats (temporary - pending payment)
        $lockedSeats = $temporaryLocks->map(function($lock) {
            return [
                'seat_id' => $lock->seat_id,
                'status' => 'locked',
                'serial_no' => $lock->serial_no,
                'locked_by_type' => $lock->locked_by_type,
                'locked_by_user_id' => $lock->locked_by_user_id,
                'vessel_snapshot' => $lock->vessel_snapshot,
                'locked_at' => $lock->locked_at ? $lock->locked_at->toDateTimeString() : null,
                'expires_at' => $lock->expires_at ? $lock->expires_at->toDateTimeString() : null,
                'expires_in_minutes' => $lock->remaining_minutes,
            ];
        })->values()->all();

        // Format booked seats (permanent - payment completed)
        $bookedSeats = $permanentLocks->map(function($lock) {
            return [
                'seat_id' => $lock->seat_id,
                'status' => 'booked',
                'booking_number' => $lock->serial_no,  // After payment, serial_no contains booking_number
                'locked_by_type' => $lock->locked_by_type,
                'locked_by_user_id' => $lock->locked_by_user_id,
                'vessel_snapshot' => $lock->vessel_snapshot,
                'booked_at' => $lock->locked_at ? $lock->locked_at->toDateTimeString() : null,
            ];
        })->values()->all();

        // Combine and index by seat_id for easy lookup
        $allBookedSeats = array_merge($lockedSeats, $bookedSeats);
        $seatIdIndex = [];
        foreach ($allBookedSeats as $seat) {
            $seatIdIndex[$seat['seat_id']] = $seat;
        }

        return $this->success([
            'schedule_id' => $validated['schedule_id'],
            'travel_date' => $validated['travel_date'],
            'total_locked' => count($lockedSeats),
            'total_booked' => count($bookedSeats),
            'total_unavailable' => count($allBookedSeats),
            'locked_seats' => $lockedSeats,
            'booked_seats' => $bookedSeats,
            'seat_status_map' => $seatIdIndex,
        ], 'Seat availability retrieved successfully');
    }
}
