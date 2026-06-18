<?php

namespace App\Actions\Teller\BookedPassenger;

use App\Actions\Action;
use App\Models\Teller\BookedPassenger;
use App\Models\Teller\ScheduleSeatLock;
use App\Models\Teller\TempBooking;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class DeleteBookedPassengerAction extends Action
{
    public function execute(int $bookedPassengerId)
    {
        if ($bookedPassengerId <= 0) {
            return $this->error('Invalid passenger ID provided. Please provide a valid temp_booked_passenger_id in the URL: DELETE /teller-booking/book-passenger/{id}', 400);
        }

        try {
            $bookedPassenger = BookedPassenger::findOrFail($bookedPassengerId);

            DB::connection('teller_booking')->transaction(function () use ($bookedPassenger) {
                if ($bookedPassenger->seat_id) {
                    $tempBooking = TempBooking::find($bookedPassenger->temp_booking_id);
                    if ($tempBooking) {
                        ScheduleSeatLock::where('serial_no', $tempBooking->serial_no)
                            ->where('seat_id', $bookedPassenger->seat_id)
                            ->delete();
                    }
                }
                $bookedPassenger->delete();
            });

            return $this->success([], 'Booked passenger deleted successfully', 204);
        } catch (ModelNotFoundException $e) {
            throw new RuntimeException("Booked passenger with ID {$bookedPassengerId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to delete booked passenger.');
        }
    }
}

