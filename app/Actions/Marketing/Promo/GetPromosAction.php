<?php

namespace App\Actions\Marketing\Promo;

use App\Actions\Action;
use App\Models\Marketing\Promo;
use Illuminate\Database\QueryException;
use RuntimeException;
use Exception;

class GetPromosAction extends Action
{
    public function execute()
    {
        try {
            $promos = Promo::all();

            return $this->success([
                'promos' => $promos,
            ], 'promos retrieved successfully');
        } catch (QueryException $e) {
            throw new RuntimeException('Database error while retrieving merchants.');
        } catch (Exception $e) {
            throw new RuntimeException('Failed to retrieve promos.');
        }
    }
}
