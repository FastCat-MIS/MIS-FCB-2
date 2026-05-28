<?php

namespace App\Actions\Teller\Seat;

use App\Actions\Action;
use App\Models\Teller\ScheduleSeatLock;
use App\Models\Operations\VesselSeat;
use App\Models\Operations\VesselAccommodation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GetScheduleSeatsAvailabilityAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'schedule_id' => 'required|integer|min:1',
            'travel_date' => 'required|date',
            'vessel_id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        // Get all vessel accommodations for this vessel
        $vesselAccommodations = VesselAccommodation::where('vessel_id', $validated['vessel_id'])
            ->pluck('id')
            ->toArray();

        // Get all seats for these accommodations
        $seats = VesselSeat::whereIn('vessel_accommodation_id', $vesselAccommodations)
            ->where('blocked', false)  // Exclude blocked seats
            ->where('path', false)     // Exclude path seats
            ->orderBy('seat_no')
            ->get();

        // Get ALL seat locks for this schedule + date (both temp and permanent)
        $allLocks = ScheduleSeatLock::where('schedule_id', $validated['schedule_id'])
            ->where('travel_date', $validated['travel_date'])
            ->get();

        // Separate into temporary (locked) and permanent (booked)
        $temporaryLocks = $allLocks->filter(function($lock) {
            return $lock->expires_at !== null && $lock->expires_at > now();
        })->keyBy('seat_id');

        $permanentLocks = $allLocks->filter(function($lock) {
            return $lock->expires_at === null;
        });

        $bookedSeatIds = $permanentLocks->pluck('seat_id')->toArray();

        // Build seat availability map
        $seatsAvailability = $seats->map(function($seat) use ($temporaryLocks, $bookedSeatIds) {
            $seatId = $seat->id;

            // Check if permanently booked
            if (in_array($seatId, $bookedSeatIds)) {
                return [
                    'seat_id' => $seatId,
                    'seat_number' => $seat->seat_no,
                    'row' => $seat->row,
                    'col' => $seat->col,
                    'pwd' => $seat->pwd,
                    'facility' => $seat->facility,
                    'status' => 'booked',
                    'available' => false,
                ];
            }

            // Check if locked (temporary booking)
            if (isset($temporaryLocks[$seatId])) {
                $lock = $temporaryLocks[$seatId];
                return [
                    'seat_id' => $seatId,
                    'seat_number' => $seat->seat_no,
                    'row' => $seat->row,
                    'col' => $seat->col,
                    'pwd' => $seat->pwd,
                    'facility' => $seat->facility,
                    'status' => 'locked',
                    'available' => false,
                    'locked_by_type' => $lock->locked_by_type,
                    'locked_by_user_id' => $lock->locked_by_user_id,
                    'serial_no' => $lock->serial_no,
                    'expires_at' => $lock->expires_at ? $lock->expires_at->toDateTimeString() : null,
                    'expires_in_minutes' => $lock->remaining_minutes,
                ];
            }

            // Seat is available
            return [
                'seat_id' => $seatId,
                'seat_number' => $seat->seat_no,
                'row' => $seat->row,
                'col' => $seat->col,
                'pwd' => $seat->pwd,
                'facility' => $seat->facility,
                'status' => 'available',
                'available' => true,
            ];
        });

        // Convert to array and count by status
        $seatsArray = $seatsAvailability->values()->all();
        $availableCount = 0;
        $lockedCount = 0;
        $bookedCount = 0;
        
        foreach ($seatsArray as $seat) {
            if ($seat['status'] === 'available') $availableCount++;
            elseif ($seat['status'] === 'locked') $lockedCount++;
            elseif ($seat['status'] === 'booked') $bookedCount++;
        }

        return $this->success([
            'schedule_id' => $validated['schedule_id'],
            'travel_date' => $validated['travel_date'],
            'vessel_id' => $validated['vessel_id'],
            'total_seats' => count($seatsArray),
            'available_count' => $availableCount,
            'locked_count' => $lockedCount,
            'booked_count' => $bookedCount,
            'seats' => $seatsArray,
        ], 'Seat availability retrieved successfully');
    }
}
