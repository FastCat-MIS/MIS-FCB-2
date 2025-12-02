<?php

namespace App\Actions\Operations\Ports;

use App\Actions\Action;
use App\Models\Operations\Port;

class GetPortAction extends Action
{
    public function execute(Port $port)
    {
        $port->load('route'); // include associated route

        return $this->success([
            'port' => $port,
        ], 'Port retrieved successfully');
    }
}
