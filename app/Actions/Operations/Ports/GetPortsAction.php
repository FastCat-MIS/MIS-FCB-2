<?php
// app/Actions/Operations/Ports/GetPortsAction.php

namespace App\Actions\Operations\Ports;

use App\Actions\Action;
use App\Models\Operations\Port;

class GetPortsAction extends Action
{
    public function execute()
    {
        $ports = Port::all();

        return $this->success([
            'ports' => $ports,
        ], 'Ports retrieved successfully');
    }
}
