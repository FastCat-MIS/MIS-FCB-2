<?php

namespace App\Actions\Marketing\Rate\AccommodationRates;

use App\Actions\Action;
use App\Models\Marketing\AccommodationRate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateAccommodationRateAction extends Action
{
    public function execute(array $data)
        {
        $validated = $this->validate($data);

        $accRate = AccommodationRate::create($validated);

        return $this->success([
            'accRate' => $accRate,
        ], 'Accommodation Rate created successfully', 201);
        }

    private function validate(array $data): array
    {
      return Validator::make($data, [
            'route_id'       => 'required|integer|exists:routes,route_id',
            'accommodation_id' => 'required|integer|exists:passenger_accommodations,accommodation_id',
            'base_rate'   => 'required|numeric|min:0',
            'effective_date' => 'nullable|date',
            'status'         => 'nullable|in:active,inactive',
        ])->validate();
    }
}