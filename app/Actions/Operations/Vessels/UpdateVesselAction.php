<?php

namespace App\Actions\Operations\Vessels;

use App\Actions\Action;
use App\Models\Operations\Vessel;
use App\Models\Operations\VesselAccommodation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateVesselAction extends Action
{
    public function execute(Vessel $vessel, array $data)
    {
        // All fields nullable for partial update
        $validator = Validator::make($data, [
            'vessel_name' => 'sometimes|string|max:100|unique:vessels,vessel_name,' . $vessel->id,
            'capacity' => 'sometimes|nullable|integer|min:0',
            'description' => 'sometimes|nullable|string',
            'status' => 'sometimes|nullable|string|max:20',
            'accommodations' => 'sometimes|array',
            'accommodations.*.accommodation_id' => 'required_with:accommodations|exists:passenger_accommodations,accommodation_id',
            'accommodations.*.seats' => 'sometimes|nullable|integer|min:0',
            'accommodations.*.aircon' => 'sometimes|nullable|boolean',
            'accommodations.*.wifi' => 'sometimes|nullable|boolean',
            'route_id' => 'sometimes|nullable|exists:routes,id',

        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        // Update vessel fields if provided
        $vessel->update($validated);

        // Sync accommodations if provided
        if (isset($validated['accommodations'])) {
            $existingIds = $vessel->accommodations()->pluck('accommodation_id')->toArray();
            $incomingIds = array_column($validated['accommodations'], 'accommodation_id');

            // Delete removed accommodations
            $toDelete = array_diff($existingIds, $incomingIds);
            VesselAccommodation::where('vessel_id', $vessel->id)
                ->whereIn('accommodation_id', $toDelete)
                ->delete();

            // Create or update incoming accommodations
            foreach ($validated['accommodations'] as $acc) {
                $vesselAcc = VesselAccommodation::firstOrNew([
                    'vessel_id' => $vessel->id,
                    'accommodation_id' => $acc['accommodation_id'],
                ]);
                $vesselAcc->fill([
                    'seats' => $acc['seats'] ?? $vesselAcc->seats ?? 0,
                    'aircon' => $acc['aircon'] ?? $vesselAcc->aircon ?? false,
                    'wifi' => $acc['wifi'] ?? $vesselAcc->wifi ?? false,
                ]);
                $vesselAcc->save();
            }
        }

        return $this->success([
            'vessel' => $vessel->fresh()->load('accommodations.accommodation')
        ], 'Vessel updated successfully.');
    }
}
