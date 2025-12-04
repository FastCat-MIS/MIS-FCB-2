<?php

namespace App\Actions\Operations\Ports;

use App\Actions\Action;
use App\Models\Operations\Port;

class GetPortAction extends Action
{
    public function execute(Port $port)
    {
        return $this->success([
            'port' => $port,
        ], 'Port retrieved successfully');
    }
}
