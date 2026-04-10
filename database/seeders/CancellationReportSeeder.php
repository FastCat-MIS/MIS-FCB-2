<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\CancellationReport;
use App\Models\Operations\Vessel;
use App\Models\Operations\Schedule;
use App\Models\Operations\Port;
use App\Models\Accounts\User;

class CancellationReportSeeder extends Seeder
{
    public function run(): void
    {
        $vessel = Vessel::first();
        $schedule = Schedule::first();
        $port = Port::first();
        $vesselMaster = User::where('email', 'vesselmaster@example.com')->first();

        if (!$vessel || !$schedule || !$port || !$vesselMaster) {
            $this->command->warn('Missing vessel, schedule, port, or vessel master. Please seed those first.');
            return;
        }

        $records = [
            [
                'port_id'                 => $port->port_id,
                'vessel_id'               => $vessel->id,
                'schedule_id'             => $schedule->sched_id,
                'vessel_master_id'        => $vesselMaster->id,
                'cancellation_category'   => 'Weather',
                'cancellation_type'       => 'Full Cancellation',
                'num_passengers_affected' => 120,
                'num_rcs_affected'        => 15,
                'est_revenue_loss'        => 48000.00,
                'consulted_dept'          => 'Operations',
                'reason_of_cancel'        => 'Typhoon Signal No. 2 raised in the area. PAGASA advisory deemed sailing unsafe.',
                'recommendation'          => 'Reschedule to next available slot once signal is lifted.',
                'documents'               => null,
            ],
            [
                'port_id'                 => $port->port_id,
                'vessel_id'               => $vessel->id,
                'schedule_id'             => $schedule->sched_id,
                'vessel_master_id'        => $vesselMaster->id,
                'cancellation_category'   => 'Mechanical',
                'cancellation_type'       => 'Partial Cancellation',
                'num_passengers_affected' => 45,
                'num_rcs_affected'        => 5,
                'est_revenue_loss'        => 18500.00,
                'consulted_dept'          => 'Engineering',
                'reason_of_cancel'        => 'Engine failure detected during pre-departure inspection. Vessel declared unfit for sailing.',
                'recommendation'          => 'Coordinate with engineering team for immediate repair and inspection before next voyage.',
                'documents'               => null,
            ],
        ];

        foreach ($records as $record) {
            $now       = now();
            $portPart  = str_pad($record['port_id'], 2, '0', STR_PAD_LEFT);
            $yearHex   = strtoupper(dechex($now->year));
            $monthHex  = strtoupper(dechex($now->month));
            $count     = CancellationReport::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->count();
            $countPart = str_pad($count, 4, '0', STR_PAD_LEFT);

            $record['control_number'] = "{$portPart}{$yearHex}{$monthHex}-{$countPart}";

            CancellationReport::create($record);
        }

        $this->command->info(count($records) . ' cancellation report records seeded successfully.');
    }
}
