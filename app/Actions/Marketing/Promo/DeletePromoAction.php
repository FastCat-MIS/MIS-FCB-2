<?php

namespace App\Actions\Marketing\Promo;

use App\Actions\Action;
use App\Models\Marketing\Promo;
use RuntimeException;

class DeletePromoAction extends Action
{
    public function execute(int $promoId)
    {
        try {

            $promo = Promo::findOrFail($promoId);
            
            $promo->delete();
            return $this->success([], 'Promo deleted successfully', 204);
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to delete promo.');
        }
    }
}
