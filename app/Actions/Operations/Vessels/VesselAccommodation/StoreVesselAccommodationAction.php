<?php

namespace App\Actions\Operations\Vessels\VesselAccommodation;

use App\Actions\Action;
use App\Models\Operations\VesselAccommodation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class StoreVesselAccommodationAction extends Action
{
    public function execute(int $vesselId, array $data)
    {
        try {
            $validated = $this->validate($data);

            $now = now();

            $accommodations = array_map(fn($item) => [
                'vessel_id'        => $vesselId,
                'accommodation_id' => $item['accommodation_id'],
                'aircon'           => $item['aircon']  ?? false,
                'wifi'             => $item['wifi']    ?? false,
                'created_at'       => $now,
                'updated_at'       => $now,
            ], $validated['accommodations']);

            VesselAccommodation::upsert(
                $accommodations,
                ['vessel_id', 'accommodation_id'], 
                ['aircon', 'wifi', 'updated_at'] 
            );

            return $this->success([
                'accommodations' => $accommodations,
            ], 'Vessel accommodations saved successfully', 201);

        } catch (ValidationException $e) {
            return $this->error(
                'Validation failed',
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return $this->error(
                $e->getMessage(),
                400
            );
        }
    }

    private function validate(array $data): array  
    {
        return Validator::make($data, [
            'accommodations'                    => 'required|array|min:1',
            'accommodations.*.accommodation_id' => 'required|integer|exists:passenger_accommodations,accommodation_id',
            'accommodations.*.aircon'           => 'nullable|boolean',
            'accommodations.*.wifi'             => 'nullable|boolean',
        ])->validate();
    }
}