<?php

namespace App\Actions\Operations\Ports;

use App\Actions\Action;
use App\Models\Operations\Port;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdatePortAction extends Action
{
    public function execute(int $portId, array $data)
    {
        $port = Port::findOrFail($portId);

        $validator = Validator::make($data, [
            'port_name'      => 'sometimes|required|string|max:255',
            'corridor'       => 'sometimes|required|string|max:255',
            'facilities'     => 'nullable|string|max:255',
            'last_update_by' => 'sometimes|required|string|max:255',
            'is_active'      => 'sometimes|required|boolean',
        ]);

        $validator->validate();

        $port->fill($validator->validated()); 
        $port->save();                        

        return $this->success([
            'port' => $port,
        ], 'Port updated successfully');
    }
}