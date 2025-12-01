<?php

namespace App\Actions\Operations\BookedPassenger;

use App\Actions\Action;
use App\Models\Operations\BookedPassenger;
use RuntimeException;

class GetBookedPassengerByKeywordAction extends Action
{
    public function execute(string $keyword)
    {
        try {
            $bookedPassenger = BookedPassenger::with(['booking', 'discount'])
                ->where('fullname', 'like', "%{$keyword}%")
                ->orWhereHas('booking', function ($query) use ($keyword) {
                    $query->where('booking_number', 'like', "%{$keyword}%");
                })
                ->first();

            if (!$bookedPassenger) {
                return $this->error('No booked passenger found for the given keyword.', 404);
            }

            $result = [
                'passenger_id'      => $bookedPassenger->id,
                'booking_id'        => $bookedPassenger->booking_id,
                'fullname'          => $bookedPassenger->fullname,
                'discount_id'       => $bookedPassenger->discount_id,
                'amount'            => $bookedPassenger->amount,
                'vehicle_amount'    => $bookedPassenger->vehicle_amount,
                'category'          => $bookedPassenger->category,
                'type'              => $bookedPassenger->type,
                'accommodation_id'  => $bookedPassenger->accommodation_id,
                'gender'            => $bookedPassenger->gender,
                'seat'              => $bookedPassenger->seat,
                'created_at'        => $bookedPassenger->created_at,
                'updated_at'        => $bookedPassenger->updated_at,
                'deleted_at'        => $bookedPassenger->deleted_at,
                'booking'           => $bookedPassenger->booking ? [
                    'booking_id'      => $bookedPassenger->booking->id,
                    'sched_id'        => $bookedPassenger->booking->sched_id,
                    'booking_number'  => $bookedPassenger->booking->booking_number,
                    'booking_date'    => $bookedPassenger->booking->booking_date,
                    'booking_source'  => $bookedPassenger->booking->booking_source,
                    'vehicle_id'      => $bookedPassenger->booking->vehicle_id,
                    'plate_number'    => $bookedPassenger->booking->plate_number,
                    'is_connecting_trip' => $bookedPassenger->booking->is_connecting_trip,
                    'created_at'      => $bookedPassenger->booking->created_at,
                    'updated_at'      => $bookedPassenger->booking->updated_at,
                    'deleted_at'      => $bookedPassenger->booking->deleted_at,
                ] : null,
                'discount' => $bookedPassenger->discount ? [
                    'discount_id'         => $bookedPassenger->discount->id,
                    'discount_type'       => $bookedPassenger->discount->discount_type,
                    'discount_code'       => $bookedPassenger->discount->discount_code,
                    'discount_percentage' => $bookedPassenger->discount->discount_percentage,
                    'start_date'          => $bookedPassenger->discount->start_date,
                    'end_date'            => $bookedPassenger->discount->end_date,
                    'created_at'          => $bookedPassenger->discount->created_at,
                    'updated_at'          => $bookedPassenger->discount->updated_at,
                    'deleted_at'          => $bookedPassenger->discount->deleted_at,
                ] : null,
            ];

            return $this->success(['booked_passenger' => $result], 'Booked passenger retrieved successfully', 200);

        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve booked passenger: ' . $e->getMessage());
        }
    }
}
