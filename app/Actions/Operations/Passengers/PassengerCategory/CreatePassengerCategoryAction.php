<?php

namespace App\Actions\Operations\Passengers\PassengerCategory;

use App\Actions\Action;
use App\Models\Operations\PassengerCategory;
use Illuminate\Support\Facades\Validator;

class CreatePassengerCategoryAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'category' => 'required|string|unique:passenger_categories,category',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation failed.', 422, $validator->errors()->toArray());
        }

        $category = PassengerCategory::create($data);

        return $this->success([
            'category' => $category
        ], 'Passenger category created successfully.', 201);
    }
}
