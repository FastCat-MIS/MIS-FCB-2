<?php

namespace App\Actions\Teller\BookedPassenger;

use App\Actions\Action;
use App\Models\Teller\BookedPassenger;
use App\Models\Teller\TempBooking;
use App\Models\Teller\ScheduleSeatLock;
use App\Models\Operations\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class CreateBookedPassengerAction extends Action
{
    public function execute(array $data)
    {
        $data = $this->normalizeKeys($data);

        $validator = Validator::make($data, [
            // Booking-level fields (for TempBooking)
            'serial_no' => 'required|string|max:50',
            'schedule_booking_id' => 'nullable|integer|min:1',
            'is_return_trip' => 'sometimes|boolean',
            'travel_date' => 'required|date',
            'schedule_id' => 'required|integer|min:1',
            'schedule_snapshot' => 'required|date_format:H:i:s',
            'route_id' => 'required|integer|min:1',
            'route_snapshot' => 'required|string|max:255',
            'vessel_snapshot' => 'nullable|string|max:255',
            'institutional_account_id' => 'nullable|integer|min:1',
            'institutional_account_snapshot' => 'nullable|string|max:255',
            
            // Passenger-level fields
            'fullname' => 'required|string|max:255',
            'gender' => 'nullable|string|max:20',
            'passenger_type_id' => 'required|integer|min:1',
            'passenger_type_snapshot' => 'required|string|max:100',
            'passenger_category_id' => 'nullable|integer|min:1',
            'passenger_category_snapshot' => 'nullable|string|max:100',
            'seat_id' => 'nullable|integer|min:1',
            'seat_number_snapshot' => 'nullable|string|max:20',
            'fare' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_id' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        
        // Auto-populate created_by from JWT token
        $createdBy = auth()->id() ?? \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->getClaim('user_id');
        $validated['created_by'] = $createdBy;

        // Wrap in transaction for atomicity
        DB::connection('teller_booking')->beginTransaction();
        
        try {
            // Find or create temp_booking
            $tempBooking = TempBooking::where('serial_no', $validated['serial_no'])->first();
        
            if ($tempBooking) {
                // Update only the fields that are provided
                $updateData = [];
            if (isset($validated['schedule_booking_id'])) $updateData['schedule_booking_id'] = $validated['schedule_booking_id'];
            if (isset($validated['is_return_trip'])) $updateData['is_return_trip'] = $validated['is_return_trip'];
            if (isset($validated['travel_date'])) $updateData['travel_date'] = $validated['travel_date'];
            if (isset($validated['schedule_id'])) $updateData['schedule_id'] = $validated['schedule_id'];
            if (isset($validated['schedule_snapshot'])) $updateData['schedule_snapshot'] = $validated['schedule_snapshot'];
            if (isset($validated['route_id'])) $updateData['route_id'] = $validated['route_id'];
            if (isset($validated['route_snapshot'])) $updateData['route_snapshot'] = $validated['route_snapshot'];
            if (isset($validated['vessel_snapshot'])) $updateData['vessel_snapshot'] = $validated['vessel_snapshot'];
            if (isset($validated['institutional_account_id'])) $updateData['institutional_account_id'] = $validated['institutional_account_id'];
            if (isset($validated['institutional_account_snapshot'])) $updateData['institutional_account_snapshot'] = $validated['institutional_account_snapshot'];
            
                if (!empty($updateData)) {
                    $tempBooking->update($updateData);
                }
            } else {
                // Create new temp_booking
                $tempBooking = TempBooking::create([
                    'serial_no' => $validated['serial_no'],
                    'schedule_booking_id' => $validated['schedule_booking_id'] ?? null,
                    'is_return_trip' => $validated['is_return_trip'] ?? false,
                    'travel_date' => $validated['travel_date'],
                    'schedule_id' => $validated['schedule_id'],
                    'schedule_snapshot' => $validated['schedule_snapshot'],
                    'route_id' => $validated['route_id'],
                    'route_snapshot' => $validated['route_snapshot'],
                    'vessel_snapshot' => $validated['vessel_snapshot'] ?? null,
                    'institutional_account_id' => $validated['institutional_account_id'] ?? null,
                    'institutional_account_snapshot' => $validated['institutional_account_snapshot'] ?? null,
                    'booking_origin' => 'teller',
                    'created_by' => $createdBy,
                ]);
            }

            // Create passenger data
            $passengerData = [
                'temp_booking_id' => $tempBooking->temp_booking_id,
                'fullname' => $validated['fullname'],
                'gender' => $validated['gender'] ?? null,
                'passenger_type_id' => $validated['passenger_type_id'],
                'passenger_type_snapshot' => $validated['passenger_type_snapshot'],
                'passenger_category_id' => $validated['passenger_category_id'] ?? null,
                'passenger_category_snapshot' => $validated['passenger_category_snapshot'] ?? null,
                'seat_id' => $validated['seat_id'] ?? null,
                'seat_number_snapshot' => $validated['seat_number_snapshot'] ?? null,
                'fare' => $validated['fare'],
                'convenience_fee' => 2.00,
                'discount_amount' => $validated['discount_amount'] ?? 0,
                'discount_id' => $validated['discount_id'] ?? null,
            ];

            $bookedPassenger = BookedPassenger::create($passengerData);

            // Automatically lock the seat if a seat_id was provided
            // This prevents double-booking by creating a database constraint violation
            // if another transaction tries to book the same seat
            if (isset($validated['seat_id']) && $validated['seat_id'] !== null) {
                // Get vessel_id from schedule (queried from main database)
                $schedule = Schedule::find($tempBooking->schedule_id);
                
                if (!$schedule) {
                    DB::connection('teller_booking')->rollBack();
                    return $this->error("Schedule with ID {$tempBooking->schedule_id} not found", 404);
                }
                
                $vesselId = $schedule->vessel_id;
                
                try {
                    // Create seat lock - will fail with unique constraint error if seat already taken
                    $lock = ScheduleSeatLock::create([
                        'schedule_id' => $tempBooking->schedule_id,
                        'seat_id' => $validated['seat_id'],
                        'travel_date' => $tempBooking->travel_date,
                        'vessel_id' => $vesselId,
                        'vessel_snapshot' => $tempBooking->vessel_snapshot,
                        'serial_no' => $tempBooking->serial_no,
                        'locked_by_user_id' => $createdBy,
                        'locked_by_type' => 'teller',
                        'expires_at' => $bookedPassenger->expires_at ?? now()->addMinutes(30),
                    ]);
                    
                    \Log::info('Seat lock created', ['lock_id' => $lock->id, 'seat_id' => $validated['seat_id']]);
                } catch (QueryException $lockException) {
                    DB::connection('teller_booking')->rollBack();
                    
                    // Check if this is a duplicate entry error (MySQL error code 23000)
                    // This means the seat is already locked by another booking
                    if ($lockException->getCode() === '23000' && str_contains($lockException->getMessage(), 'unique_schedule_seat_date')) {
                        return $this->error('Seat already taken by another booking', 409);
                    }
                    
                    \Log::error('Failed to create seat lock', [
                        'error' => $lockException->getMessage(),
                        'seat_id' => $validated['seat_id'],
                        'schedule_id' => $tempBooking->schedule_id,
                    ]);
                    
                    throw $lockException;
                }
            } else {
                \Log::info('No seat lock created - seat_id not provided or null', ['seat_id' => $validated['seat_id'] ?? 'not set']);
            }

            DB::connection('teller_booking')->commit();

            return $this->success([
                'booked_passenger' => $bookedPassenger,
                'temp_booking' => $tempBooking,
            ], 'Booked passenger created successfully', 201);
            
        } catch (QueryException $e) {
            DB::connection('teller_booking')->rollBack();
            
            // Check if duplicate entry error (seat already locked)
            if ($e->getCode() === '23000' && str_contains($e->getMessage(), 'unique_schedule_seat_date')) {
                return $this->error('Seat already taken by another booking', 409);
            }
            
            throw $e;
        } catch (\Exception $e) {
            DB::connection('teller_booking')->rollBack();
            throw $e;
        }
    }

    private function normalizeKeys(array $data): array
    {
        $map = [
            'bookingId' => 'booking_id',
            'scheduleBookingId' => 'schedule_booking_id',
            'isReturnTrip' => 'is_return_trip',
            'travelDate' => 'travel_date',
            'scheduleId' => 'schedule_id',
            'scheduleSnapshot' => 'schedule_snapshot',
            'routeId' => 'route_id',
            'routeSnapshot' => 'route_snapshot',
            'vesselSnapshot' => 'vessel_snapshot',
            'passengerTypeId' => 'passenger_type_id',
            'passengerTypeSnapshot' => 'passenger_type_snapshot',
            'passengerCategoryId' => 'passenger_category_id',
            'passengerCategorySnapshot' => 'passenger_category_snapshot',
            'seatId' => 'seat_id',
            'seatNumberSnapshot' => 'seat_number_snapshot',
            'discountAmount' => 'discount_amount',
            'discountId' => 'discount_id',
            'institutionalAccountId' => 'institutional_account_id',
        ];

        foreach ($map as $from => $to) {
            if (array_key_exists($from, $data) && !array_key_exists($to, $data)) {
                $data[$to] = $data[$from];
            }
        }

        return $data;
    }
}
