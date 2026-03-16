<?php

namespace App\Actions\Marketing\Promo;

use App\Actions\Action;
use App\Models\Marketing\Promo;
use RuntimeException;

class GetPromoAction extends Action
{
    public function execute(int $promoId)
    {
        try {
            $promo = Promo::findOrFail($promoId);

            return $this->success([
                'promo' => $promo,
            ], 'promo retrieved successfully');
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve promo.');
        }
    }
}
