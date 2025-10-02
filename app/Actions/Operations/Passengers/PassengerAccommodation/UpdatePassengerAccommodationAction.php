<?php
// app/Actions/Operations/Passengers/PassengerAccommodation/UpdatePassengerAccommodationAction.php

namespace App\Actions\Operations\Passengers\PassengerAccommodation;

use App\Actions\Action;
use App\Models\Operations\PassengerAccommodation;
use Illuminate\Support\Facades\Validator;

class UpdatePassengerAccommodationAction extends Action
{
    public function execute(PassengerAccommodation $accommodation, array $data)
    {
        try {
            $validator = Validator::make($data, [
                'accomodation_name' => 'sometimes|required|string|max:255',
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed.', 422, $validator->errors()->toArray());
            }

            $accommodation->update($data);

            return $this->success([
                'passengerAccommodation' => $accommodation->fresh(),
            ], 'Passenger Accommodation updated successfully');

        } catch (\Exception $e) {
            return $this->error('Failed to update accommodation.', 500, $e->getMessage());
        }
    }
}
