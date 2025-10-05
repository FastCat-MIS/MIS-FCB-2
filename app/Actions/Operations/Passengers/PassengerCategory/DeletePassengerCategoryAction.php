<?php

namespace App\Actions\Operations\Passengers\PassengerCategory;

use App\Actions\Action;
use App\Models\Operations\PassengerCategory;

class DeletePassengerCategoryAction extends Action
{
    public function execute(PassengerCategory $passengerCategory)
    {
        try {
            $passengerCategory->delete();

            return $this->success([], 'Passenger category deleted successfully.', 204);
        } catch (\Throwable $e) {
            throw new \Exception('Failed to delete passenger category: ' . $e->getMessage(), 500);
        }
    }
}
