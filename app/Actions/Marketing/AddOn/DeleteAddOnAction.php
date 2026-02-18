<?php

namespace App\Actions\Marketing\AddOn;

use App\Actions\Action;
use App\Models\Marketing\AddOn;
use RuntimeException;

class DeleteAddOnAction extends Action
{
    public function execute(AddOn $addOn)
    {
        try {
            $addOn->delete();

            return $this->success([], 'Add On deleted successfully', 204);
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to delete add on.');
        }
    }
}