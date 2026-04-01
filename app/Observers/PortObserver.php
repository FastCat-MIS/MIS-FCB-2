<?php

namespace App\Observers;

use App\Models\Operations\Port;
use App\Models\Operations\Route;
use App\Models\Operations\Schedule;
use Illuminate\Support\Facades\Log;

class PortObserver
{
    public function updating(Port $port): void
    {
        Log::info('PortObserver updating fired', [
        'port_id'   => $port->port_id,
        'dirty'     => $port->getDirty(),
    ]);
        if (!$port->isDirty('is_active')) return;

       
        $this->setDependentsStatus($port->port_id, (bool) $port->is_active);

    }

    private function setDependentsStatus(int $portId, bool $status): void
    {
        Route::where('port_a_id', $portId)
            ->orWhere('port_b_id', $portId)
            ->update(['is_active' => $status]);

        Schedule::where('port_id', $portId)
            ->update(['is_active' => $status]);
    }
}