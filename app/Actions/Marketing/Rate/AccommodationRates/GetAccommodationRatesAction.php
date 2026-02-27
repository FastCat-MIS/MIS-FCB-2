<?php

namespace App\Actions\Marketing\Rate\AccommodationRates;

use App\Actions\Action;
use App\Models\Marketing\AccommodationRate;
use RuntimeException;

class GetAccommodationRatesAction extends Action
{
  public function execute()
    {
      try {
        $accRates = AccommodationRate::get();
                    return $this->success([
                'accRates' => $accRates,
            ], 'Accommodation Rates retrieved successfully');
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve accommodation rates.');
        }
    }
}