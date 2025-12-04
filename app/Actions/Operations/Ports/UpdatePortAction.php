<?php

namespace App\Actions\Operations\Ports;

use App\Actions\Action;
use App\Models\Operations\Port;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdatePortAction extends Action
{
    public function execute(Port $port, array $data)
    {
        $validator = Validator::make($data, [
            'port_name' => 'sometimes|required|string|max:255',
            'corridor' => 'sometimes|required|string|max:255',
            'facilities' => 'nullable|string|max:255',
            'last_update_by' => 'sometimes|required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validator->validate();

        $port->update($validator->validated());

        return $this->success([
            'port' => $port,
        ], 'Port updated successfully');
    }
}
