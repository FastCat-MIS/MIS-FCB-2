<?php

namespace App\Actions\Marketing\Discount;

use App\Actions\Action;
use App\Models\Marketing\Discounts\Discount;
use Illuminate\Database\QueryException;
use RuntimeException;
use Exception;

class GetDiscountsAction extends Action
{
    public function execute()
    {
        try {
            $discounts = Discount::all();

            return $this->success([
                'discounts' => $discounts,
            ], 'Discounts retrieved successfully');
        } catch (QueryException $e) {
            throw new RuntimeException('Database error while retrieving merchants.');
        } catch (Exception $e) {
            throw new RuntimeException('Failed to retrieve discounts.');
        }
    }
}
