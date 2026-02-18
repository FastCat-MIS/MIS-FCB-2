<?php

namespace App\Actions\Marketing\AddOn;

use App\Actions\Action;
use App\Models\Marketing\AddOn;
use RuntimeException;

class GetAddOnAction extends Action
{
    public function execute(AddOn $addOn)
        {
            try {
                return $this->success([
                    'addOn' => $addOn,
                ], 'Add On retrieved successfully');
            } catch (\Exception $e) {
                throw new RuntimeException('Failed to retrieve Add On.');
            }
        }
}