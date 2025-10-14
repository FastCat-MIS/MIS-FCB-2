<?php
// app/Actions/Operations/Ports/DeletePortAction.php

namespace App\Actions\Operations\Ports;

use App\Actions\Action;
use App\Models\Operations\Port;

class DeletePortAction extends Action
{
    public function execute(Port $port)
    {
        $port->delete();

        return $this->success([], 'Port deleted successfully', 204);
    }
}
