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
            $promo = Promo::with([
                'promoConditions.vehicle:vehicle_id,vehicle_class',
                'promoConditions.passengerType:p_id,type,discount',
                'promoConditions.schedule:sched_id,departure_time',
                'promoConditions.port:port_id,port_name',
                'promoConditions.accommodation:accommodation_id,accommodation_name'
            ])->findOrFail($promoId);

            return $this->success([
                'promo' => $promo,
            ], 'Promo retrieved successfully');

        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve promo: ' . $e->getMessage());
        }
    }
}