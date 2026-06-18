<?php

namespace App\Actions\Teller\Booking;

use App\Actions\Action;
use App\Models\Teller\ScheduleSeatLock;
use App\Models\Teller\TempBooking;
use Illuminate\Support\Facades\DB;

class CancelTempBookingAction extends Action
{
    public function execute(string $serialNo)
    {
        $createdBy = auth()->id() ?? \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->getClaim('user_id');

        $tempBooking = TempBooking::with(['passengers', 'vehicles'])
            ->where('serial_no', $serialNo)
            ->first();

        if (!$tempBooking) {
            return $this->error('Booking not found', 404);
        }

        if ((string) $tempBooking->created_by !== (string) $createdBy) {
            return $this->error('Unauthorized: this booking belongs to another teller', 403);
        }

        DB::connection('teller_booking')->transaction(function () use ($tempBooking, $serialNo) {
            ScheduleSeatLock::where('serial_no', $serialNo)->delete();

            foreach ($tempBooking->passengers as $passenger) {
                $passenger->forceDelete();
            }

            foreach ($tempBooking->vehicles as $vehicle) {
                $vehicle->forceDelete();
            }

            $tempBooking->delete();
        });

        return $this->success([], 'Booking cancelled and all seat locks released', 200);
    }
}
