<?php

namespace App\Actions\Teller\Waybill;

use App\Actions\Action;
use App\Models\Teller\Booking;
use App\Models\Operations\Schedule;

class GenerateWaybillAction extends Action
{
    /**
     * Generate waybills (Bill of Lading) for vehicles in a completed booking
     * 
     * Creates printable A4 waybill documents for each vehicle. Used as official
     * cargo manifest and receipt for vehicle transportation.
     * 
     * @param string $bookingNumber The permanent booking number (format: 7EA5-00001)
     * @return mixed Blade view with waybill data or error response
     */
    public function execute(string $bookingNumber)
    {
        // Fetch booking with relationships
        $booking = Booking::with(['vehicles.driver', 'payment'])
            ->where('booking_number', $bookingNumber)
            ->first();

        if (!$booking) {
            return $this->error(null, 'Booking not found', 404);
        }

        // Check if booking has vehicles - waybills only for vehicle bookings
        if ($booking->vehicles->isEmpty()) {
            return $this->error(null, 'No vehicles found for this booking', 404);
        }

        // Get schedule details
        $schedule = Schedule::with(['vessel', 'port'])->find($booking->schedule_id);

        if (!$schedule) {
            return $this->error(null, 'Schedule not found', 404);
        }

        // Extract route information from snapshot (auto-cast to array by model)
        $routeSnapshot = $booking->route_snapshot;

        $portOrigin = $routeSnapshot['port_a_name'] ?? 'N/A';
        $portDestination = $routeSnapshot['port_b_name'] ?? 'N/A';

        // Extract vessel information from snapshot (auto-cast to array by model)
        $vesselSnapshot = $booking->vessel_snapshot;

        $vesselName = $vesselSnapshot['vessel_name'] ?? ($schedule->vessel->vessel_name ?? 'N/A');

        // Generate waybill document for each vehicle in the booking
        $waybills = [];
        foreach ($booking->vehicles as $vehicle) {
            // Get driver information from linked passenger record
            $driver = $vehicle->driver;
            $driverName = $driver ? $driver->fullname : 'N/A';
            
            // Address field placeholder - passenger category snapshot is auto-cast to array
            $address = 'N/A';

            // Calculate total charges including fixed admin fee
            $netAmount = (float) $vehicle->fare;
            $adminFee = 25.00;
            $totalCharges = $netAmount + $adminFee;
            $amountInWords = $this->convertNumberToWords($totalCharges);

            // Generate QR code data string for waybill validation
            $qrData = implode(',', [
                $booking->travel_date->format('Y-m-d'),
                $schedule->port_id,
                $schedule->sched_id,
                $booking->booking_number,
                $driverName
            ]);

            // Voyage code placeholder - voyage tracking system not yet implemented
            $voyageCode = 'N/A';

            $waybills[] = [
                'voyage_code' => $voyageCode,
                'series_number' => 'N/A',
                'vessel_name' => $vesselName,
                'travel_date' => $booking->travel_date,
                'shipper' => $driverName,
                'address' => $address,
                'port_origin' => $portOrigin,
                'port_destination' => $portDestination,
                'classification' => ($vehicle->length ?? 0) > 0 ? 'Vehicle' : 'N/A',
                'description' => $vehicle->vehicle_type . ' ' . $vehicle->plate_no,
                'rate' => number_format($vehicle->fare, 2),
                'freight_charges' => number_format($netAmount, 2),
                'admin_fee' => number_format($adminFee, 2),
                'total_charges' => number_format($totalCharges, 2),
                'amount_in_words' => $amountInWords,
                'qr_data' => urlencode($qrData),
                'booking_number' => $booking->booking_number,
            ];
        }

        // Return view with waybills data
        return view('waybills.generate', ['waybills' => $waybills]);
    }

    /**
     * Convert numeric amount to words for waybill
     * 
     * Converts a decimal number to its English word representation
     * with Philippine peso format.
     * 
     * Example: 1250.50 => "One Thousand Two Hundred Fifty Pesos and Fifty Centavos"
     * 
     * @param float|int $number The amount to convert
     * @return string The amount in words
     */
    private function convertNumberToWords($number): string
    {
        $number = (float) $number;
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $digits_length = strlen($no);
        $i = 0;
        $str = [];
        $words = [
            0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        ];
        $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];

        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) 
                    ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred 
                    : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else {
                $str[] = null;
            }
        }

        $pesos = implode('', array_reverse($str));
        $centavos = ($decimal > 0) 
            ? " and " . ($words[$decimal / 10 * 10] . " " . $words[$decimal % 10]) . ' Centavos' 
            : '';

        return ($pesos ? $pesos . 'Pesos' : '') . $centavos;
    }
}
