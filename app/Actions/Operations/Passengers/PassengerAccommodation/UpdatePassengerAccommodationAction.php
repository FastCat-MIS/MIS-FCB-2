<?php

namespace App\Actions\Operations\Passengers\PassengerAccommodation;

use App\Actions\Action;
use App\Models\Operations\PassengerAccommodation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class UpdatePassengerAccommodationAction extends Action
{
    public function execute(int $accommodationId, array $data)
    {
        $validator = Validator::make($data, [
            "accommodation_name" => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            $accommodation = PassengerAccommodation::findOrFail($accommodationId);

            $accommodation->update($validator->validated());

            return $this->success([
                'accommodation' => $accommodation
            ], 'Accommodation updated successfully');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new RuntimeException("Accommodation with ID {$accommodationId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to update accommodation.');
        }
    }
}