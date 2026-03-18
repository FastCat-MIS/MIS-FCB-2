<?php

namespace App\Actions\Marketing\Promo;

use App\Actions\Action;
use App\Models\Marketing\Promo;
use App\Models\Marketing\PromoCondition;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class CreatePromoAction extends Action
{
    public function execute(array $data)
    {
        try {
            $validated = $this->validate($data);

            $promo = DB::transaction(function () use ($validated, $data) {
                $validated['promo_cn'] = $this->generatePromoCN();
                
                $promo = Promo::create($validated);

                if ($data['condition'] === 1) {
                    $this->generateConditions($promo->promo_id, $data['promo_conditions'] ?? []);
                }

                return $promo;
            });

            return $this->success([
                'promo' => $promo,
            ], 'Promo created successfully', 201);

        } catch (ValidationException $e) {

            return $this->error(
                'Validation failed',
                422,
                $e->errors()
            );

        } catch (Exception $e) {

            return $this->error(
                $e->getMessage(),
                400
            );
        }
    }

    private function validate(array $data): array
    {
        return Validator::make($data, [
            'promo_name'     => 'required|string|max:225',
            'promo_code'     => [
                'required',
                'string',
                'max:100',
                Rule::unique('promos', 'promo_code')->whereNull('deleted_at'),
            ],
            'promo_value'    => 'required|numeric|min:0',
            'value_type'     => 'required|in:0,1',
            'effective_date' => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:effective_date',
            'status'         => 'nullable|in:0,1,2,3',
            'round_trip'         => 'nullable|in:0,1',
            'condition'         => 'nullable|in:0,1',

            'promo_conditions'                    => 'nullable|array',
            'promo_conditions.vehicles'           => 'nullable|array',
            'promo_conditions.vehicles.*'         => 'integer|exists:vehicles,vehicle_id',
            'promo_conditions.ports'              => 'nullable|array',
            'promo_conditions.ports.*'            => 'integer|exists:ports,port_id',
            'promo_conditions.schedules'          => 'nullable|array',
            'promo_conditions.schedules.*'        => 'integer|exists:schedules,sched_id',
            'promo_conditions.accommodation'      => 'nullable|array',
            'promo_conditions.accommodation.*'    => 'integer|exists:passenger_accommodations,accommodation_id',
            'promo_conditions.passenger'          => 'nullable|array',
            'promo_conditions.passenger.*.id'     => 'required_with:promo_conditions.passenger|integer|exists:passenger_types,p_id',
            'promo_conditions.passenger.*.pax'    => 'required_with:promo_conditions.passenger|integer|min:1',
        ])->validate();
    }

    private function generatePromoCN(): string
    {
        $now = Carbon::now();

        $count = Promo::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->lockForUpdate()
            ->count();

        if ($count >= 100) {
            throw new Exception('Maximum of 100 promos per month reached (00–99).');
        }

        $yearHex  = strtoupper(dechex($now->year));
        $monthHex = strtoupper(str_pad(dechex($now->month), STR_PAD_LEFT)); // 👈 fixed: was missing length, pad string, and pad type
        $decimal  = str_pad($count, 2, '0', STR_PAD_LEFT);

        return $yearHex . $monthHex . '-' . $decimal;
    }

    private function generateConditions(int $promoId, array $conditions): void
    {
        $vehicles      = $conditions['vehicles']      ?? [];
        $ports         = $conditions['ports']         ?? [];
        $schedules     = $conditions['schedules']     ?? [];
        $accommodation = $conditions['accommodation'] ?? [];
        $passengers    = $conditions['passenger']     ?? [];

        $maxRows = max(
            count($vehicles),
            count($ports),
            count($schedules),
            count($accommodation),
            count($passengers),
            1
        );

        $now  = now();
        $rows = [];

        for ($i = 0; $i < $maxRows; $i++) {
            $rows[] = [
                'promo_id'   => $promoId,
                'vehicle_id' => $vehicles[$i]              ?? null,
                'port_id'    => $ports[$i]                 ?? null,
                'sched_id'   => $schedules[$i]             ?? null,
                'accommodation_id'   => $accommodation[$i]         ?? null,
                'ptype_id'   => $passengers[$i]['id']      ?? null,
                'pax'        => $passengers[$i]['pax']     ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($rows)) {
            PromoCondition::insert($rows);
        }
    }
}