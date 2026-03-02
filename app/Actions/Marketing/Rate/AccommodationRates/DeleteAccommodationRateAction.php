<?php

namespace App\Actions\Marketing\Rate\AccommodationRates;

use App\Actions\Action;
use App\Models\Marketing\AccommodationRate;
use RuntimeException;

class DeleteAccommodationRateAction extends Action
{

    public function execute(int $accRateId)
    {
        try {
            $accRate = AccommodationRate::findOrFail($accRateId); 

            $accRate->delete();

            return $this->success([], 'Accommodation Rate deleted successfully', 204);        
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new RuntimeException("Accommodation Rate with ID {$accRateId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to delete accommodation rate.');
        }
    }
}