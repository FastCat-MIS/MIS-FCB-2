<?php

namespace App\Actions\Operations\Vessels;

use App\Actions\Action;
use App\Models\Operations\Vessel;
use App\Models\Operations\VesselAccommodation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateVesselAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'vessel_name' => 'required|string|max:100|unique:vessels,vessel_name',
            'capacity' => 'sometimes|nullable|integer|min:0',
            'decklane_length_capacity' => 'sometimes|nullable|integer|min:0',
            'weight_capacity' => 'sometimes|nullable|integer|min:0',
            'description' => 'sometimes|nullable|string',
            'status'         => 'nullable|in:0,1,2,3',
            'accommodations' => 'sometimes|array',
            'accommodations.*.accommodation_id' => 'required_with:accommodations|exists:passenger_accommodations,accommodation_id',
            'accommodations.*.capacity' => 'sometimes|nullable|integer|min:0',
            'accommodations.*.aircon' => 'sometimes|nullable|boolean',
            'accommodations.*.wifi' => 'sometimes|nullable|boolean',
            'route_id' => 'sometimes|nullable|exists:routes,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        // Create vessel
        $vessel = Vessel::create($validated);

        // Create accommodations if provided
        if (!empty($validated['accommodations'])) {
            foreach ($validated['accommodations'] as $acc) {
                $vessel->accommodations()->create([
                    'accommodation_id' => $acc['accommodation_id'],
                    'seats' => $acc['seats'] ?? 0,
                    'aircon' => $acc['aircon'] ?? false,
                    'wifi' => $acc['wifi'] ?? false,
                ]);
            }
        }

        return $this->success([
            'vessel' => $vessel->load('accommodations.accommodation')
        ], 'Vessel created successfully', 201);
    }
}
