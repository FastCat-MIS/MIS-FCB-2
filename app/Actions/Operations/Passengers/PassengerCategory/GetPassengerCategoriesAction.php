<?php

namespace App\Actions\Operations\Passengers\PassengerCategory;

use App\Actions\Action;
use App\Models\Operations\PassengerCategory;

class GetPassengerCategoriesAction extends Action
{
    public function execute()
    {
        $categories = PassengerCategory::all();

        return $this->success([
            'categories' => $categories
        ], 'Passenger categories retrieved successfully.');
    }
}
