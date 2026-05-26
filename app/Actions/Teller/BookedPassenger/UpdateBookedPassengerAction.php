<?php

namespace App\Actions\Teller\BookedPassenger;

use App\Actions\Action;
use App\Models\Teller\BookedPassenger;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class UpdateBookedPassengerAction extends Action
{
    public function execute(int $bookedPassengerId, array $data)
    {
        $data = $this->normalizeKeys($data);

        $validator = Validator::make($data, [
            'booking_id' => 'sometimes|nullable|integer|min:1',
            'travel_date' => 'sometimes|required|date',
            'schedule_id' => 'sometimes|required|integer|min:1',
            'schedule_snapshot' => 'sometimes|required|date_format:H:i:s',
            'route_id' => 'sometimes|required|integer|min:1',
            'route_snapshot' => 'sometimes|required|string|max:255',
            'fullname' => 'sometimes|required|string|max:255',
            'gender' => 'sometimes|nullable|string|max:20',
            'passenger_type_id' => 'sometimes|required|integer|min:1',
            'passenger_type_snapshot' => 'sometimes|required|string|max:100',
            'passenger_category_id' => 'sometimes|nullable|integer|min:1',
            'passenger_category_snapshot' => 'sometimes|nullable|string|max:100',
            'seat_id' => 'sometimes|nullable|integer|min:1',
            'seat_number_snapshot' => 'sometimes|nullable|string|max:20',
            'fare' => 'sometimes|required|numeric|min:0',
            'discount_amount' => 'sometimes|nullable|numeric|min:0',
            'discount_id' => 'sometimes|nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            $bookedPassenger = BookedPassenger::findOrFail($bookedPassengerId);

            $bookedPassenger->update($validator->validated());

            return $this->success([
                'booked_passenger' => $bookedPassenger->fresh(),
            ], 'Booked passenger updated successfully');
        } catch (ModelNotFoundException $e) {
            throw new RuntimeException("Booked passenger with ID {$bookedPassengerId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to update booked passenger.');
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
