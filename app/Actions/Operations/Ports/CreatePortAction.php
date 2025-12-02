<?php

namespace App\Actions\Operations\Ports;

use App\Actions\Action;
use App\Models\Operations\Port;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreatePortAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'port_name' => 'required|string|max:255',
            'corridor' => 'required|string|max:255',
            'facilities' => 'nullable|string|max:255',
            'last_update_by' => 'required|string|max:255',
            'is_active' => 'boolean',
            'route_id' => 'nullable|exists:routes,route_id', // link port to a route
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $port = Port::create($validator->validated());
        $port->load('route'); // eager load route

        return $this->success([
            'port' => $port,
        ], 'Port created successfully', 201);
    }
}
