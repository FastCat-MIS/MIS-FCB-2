<?php

namespace App\Http\Controllers\Teller;

use App\Actions\Teller\Seat\CheckSeatAvailabilityAction;
use App\Actions\Teller\Seat\GetScheduleSeatsAvailabilityAction;
use App\Actions\Teller\Seat\GetBookedSeatsAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    /**
     * Check if a specific seat is available
     * 
     * POST /teller-booking/check-seat
     * {
     *   "schedule_id": 5,
     *   "seat_id": 12,
     *   "travel_date": "2026-05-27"
     * }
     */
    public function checkSeat(Request $request, CheckSeatAvailabilityAction $action)
    {
        return $action->execute($request->all());
    }

    /**
     * Get all seats availability for a schedule
     * 
     * GET /teller-booking/schedule-seats?schedule_id=5&travel_date=2026-05-27&vessel_id=3
     */
    public function getScheduleSeats(Request $request, GetScheduleSeatsAvailabilityAction $action)
    {
        return $action->execute($request->all());
    }

    /**
     * Get all booked/locked seats for a schedule
     * 
     * GET /teller-booking/booked-seats?schedule_id=5&travel_date=2026-05-27
     */
    public function getBookedSeats(Request $request, GetBookedSeatsAction $action)
    {
        return $action->execute($request->all());
    }
}
