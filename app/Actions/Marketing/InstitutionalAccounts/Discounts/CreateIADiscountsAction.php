<?php

namespace App\Actions\Marketing\InstitutionalAccounts\Discounts;

use App\Actions\Action;
use App\Models\Marketing\Discounts\IADiscount;
use Illuminate\Support\Facades\Validator;

class CreateIADiscountsAction extends Action
{
    public function execute(array $data)
    {
        $validated = $this->validate($data);

        $iaDiscount = IADiscount::create($validated);

        return $this->success([
            'data' => $iaDiscount,
        ], 'IA discount created successfully', 201);
    }

    private function validate(array $data): array
    {
        return Validator::make($data, [
            'vehicle_id'     => 'required|integer|exists:vehicles,vehicle_id',
            'route_id'       => 'required|integer|exists:routes,route_id',
            'vehicle_rate'   => 'required|numeric|min:0',
            'effective_date' => 'nullable|date',
            'status'         => 'nullable|in:active,inactive',
        ])->validate();
    }
}