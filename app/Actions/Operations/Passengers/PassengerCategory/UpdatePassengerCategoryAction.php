<?php

namespace App\Actions\Operations\Passengers\PassengerCategory;

use App\Actions\Action;
use App\Models\Operations\PassengerCategory;
use Illuminate\Support\Facades\Validator;

class UpdatePassengerCategoryAction extends Action
{
    public function execute(PassengerCategory $passengerCategory, array $data)
    {
        $validator = Validator::make($data, [
            'category' => 'required|string|unique:passenger_categories,category,' . $passengerCategory->p_ctgry_id . ',p_ctgry_id',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation failed.', 422, $validator->errors()->toArray());
        }

        $passengerCategory->update($data);

        return $this->success([
            'category' => $passengerCategory
        ], 'Passenger category updated successfully.');
    }
}
