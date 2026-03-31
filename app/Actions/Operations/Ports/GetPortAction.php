<?php

namespace App\Actions\Operations\Ports;

use App\Actions\Action;
use App\Models\Operations\Port;

class GetPortAction extends Action
{
    public function execute(int $portId)
    {
        $port = Port::findOrFail($portId);      
    
        return $this->success([
            'port' => $port,
        ], 'Port retrieved successfully');
    }
}
