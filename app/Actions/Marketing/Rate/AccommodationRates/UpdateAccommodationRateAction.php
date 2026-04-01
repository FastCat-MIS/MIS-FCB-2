<?php

namespace App\Actions\Marketing\Rate\AccommodationRates;

use App\Actions\Action;
use App\Models\Marketing\AccommodationRate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class UpdateAccommodationRateAction extends Action
{
    public function execute(int $accRateId, array $data)

    {
      $validator = Validator::make($data, [
        'base_rate' => 'sometimes|required|numeric|min:0',
        'status'         => 'sometimes|required|in:0,1,2,3',
      ]);
       if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $accRate = AccommodationRate::findOrFail($accRateId);
        $accRate->update($data);
        return $this->success([
            'rate' => $accRate->fresh()->load('route'),
        ], 'Accommodation Rate updated successfully');
    }

}