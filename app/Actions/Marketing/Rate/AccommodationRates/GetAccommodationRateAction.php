<?php
// app/Actions/Marketing/Rate/GetRatesAction.php

namespace App\Actions\Marketing\Rate\AccommodationRates;

use App\Actions\Action;
use App\Models\Marketing\AccommodationRate;
use RuntimeException;

class GetAccommodationRateAction extends Action
{
      public function execute(int $accRateId) 
    {
        try {
            $accRate = AccommodationRate::findOrFail($accRateId); 

            return $this->success([
                'accRate' => $accRate,
            ], 'Accommodation Rate retrieved successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new RuntimeException("Accommodation Rate with ID {$accRateId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve accommodation rate.');
        }
    }

}