<?php

namespace App\Actions\Operations\Passengers\PassengerCategory;

use App\Actions\Action;
use App\Models\Operations\PassengerCategory;
use Illuminate\Support\Facades\Validator;

class UpdatePassengerCategoryAction extends Action
{
    public function execute(PassengerCategory $passengerCategory, array $data)
    {
        $validated = Validator::make($data, [
            'category' => 'required|string|unique:passenger_categories,category,' . $passengerCategory->p_ctgry_id . ',p_ctgry_id',
        ])->validate(); // Let global exception handler catch ValidationException

        $passengerCategory->update($validated);

        return $this->success([
            'category' => $passengerCategory->fresh()
        ], 'Passenger category updated successfully.');
    }
}
