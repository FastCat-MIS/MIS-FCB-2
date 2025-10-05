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

        $validator->validate(); // Let the global handler catch ValidationException

        $category = PassengerCategory::create($data);

        return $this->success([
            'category' => $category
        ], 'Passenger category created successfully.', 201);
    }
}
