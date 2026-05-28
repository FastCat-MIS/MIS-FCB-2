<?php

namespace App\Http\Controllers\Teller;

use App\Actions\Teller\Ticket\GenerateTicketAction;
use App\Actions\Teller\Waybill\GenerateWaybillAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketController extends Controller
{

// Generate ticket
    public function generate(Request $request, GenerateTicketAction $action)
    {
        $bookingNumber = $request->query('booking_number');

        if (!$bookingNumber) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => 'Booking number is required',
                'data' => null
            ], 400);
        }

        return $action->execute($bookingNumber);
    }

// Generate waybill
    public function generateWaybill(Request $request, GenerateWaybillAction $action)
    {
        $bookingNumber = $request->query('booking_number');

        if (!$bookingNumber) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => 'Booking number is required',
                'data' => null
            ], 400);
        }

        return $action->execute($bookingNumber);
    }
}
