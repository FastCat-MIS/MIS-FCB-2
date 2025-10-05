<?php

namespace App\Actions\Operations\Passengers\PassengerCategory;

use App\Actions\Action;
use App\Models\Operations\PassengerCategory;

class GetPassengerCategoriesAction extends Action
{
    public function execute()
    {
        try {
            $categories = PassengerCategory::all();

            return $this->success([
                'categories' => $categories
            ], 'Passenger categories retrieved successfully.');
        } catch (\Throwable $e) {
            throw new \Exception('Failed to retrieve passenger categories: ' . $e->getMessage(), 500);
        }
    }
}
