<?php

namespace App\Actions\Marketing\Rate\AccommodationRates;

use App\Actions\Action;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class UpdateAccommodationRateAction extends Action
{
    public function execute($accRate, array $data)

    {
      $validator = Validator::make($data, [
        'acc_rate_id' => 'required',
        'base_rate' => 'sometimes|required|numeric|min:0',
        'status' => 'sometimes|in:active,inactive',
      ]);
       if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $accRate->update($data);
        return $this->success([
            'rate' => $accRate->fresh()->load('route'),
        ], 'Rate updated successfully');
    }

}