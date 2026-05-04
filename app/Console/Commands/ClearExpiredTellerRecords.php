<?php

namespace App\Console\Commands;

use App\Models\Teller\BookedPassenger;
use App\Models\Teller\BookedVehicle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ClearExpiredTellerRecords extends Command
{
    protected $signature = 'teller:clear-expired';
    protected $description = 'Clear expired temporary records from teller booking tables';

    public function handle()
    {
        $this->info('Clearing expired teller records...');

        // Clear expired passengers
        $passengerCount = BookedPassenger::where('expires_at', '<=', now())->delete();
        $this->info("Cleared {$passengerCount} expired passenger(s)");

        // Clear expired vehicles
        $vehicleCount = BookedVehicle::where('expires_at', '<=', now())->delete();
        $this->info("Cleared {$vehicleCount} expired vehicle(s)");

        Log::info('Expired teller records cleared', [
            'passengers' => $passengerCount,
            'vehicles' => $vehicleCount,
        ]);

        $this->info('Expired records cleared successfully.');
        return 0;
    }
}