<?php

namespace App\Actions\Marketing\Discount;

use App\Actions\Action;
use App\Models\Marketing\Discounts\Discount;
use App\Models\Marketing\Discounts\DiscountCondition;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class CreateDiscountAction extends Action
{
    public function execute(array $data)
    {
        try {
            $validated = $this->validate($data);

            $discount = DB::transaction(function () use ($validated, $data) {
                $validated['discount_cn'] = $this->generateDiscountCN();
                
                $discount = Discount::create($validated);

                if ($data['condition'] === 1) {
                    $this->generateConditions($discount->discount_id, $data['discount_conditions'] ?? []);
                }

                return $discount;
            });

            return $this->success([
                'discount' => $discount,
            ], 'Discount created successfully', 201);

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
            'discount_name'     => 'required|string|max:225',
            'discount_code'     => [
                'required',
                'string',
                'max:100',
                Rule::unique('discounts', 'discount_code')->whereNull('deleted_at'),
            ],
            'discount_value'    => 'required|numeric|min:0',
            'value_type'     => 'required|in:0,1',
            'effective_date' => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:effective_date',
            'status'         => 'nullable|in:0,1,2,3',
            'round_trip'         => 'nullable|in:0,1',
            'condition'         => 'nullable|in:0,1',

            'discount_conditions'                    => 'nullable|array',
            'discount_conditions.vehicles'           => 'nullable|array',
            'discount_conditions.vehicles.*'         => 'integer|exists:vehicles,vehicle_id',
            'discount_conditions.ports'              => 'nullable|array',
            'discount_conditions.ports.*'            => 'integer|exists:ports,port_id',
            'discount_conditions.schedules'          => 'nullable|array',
            'discount_conditions.schedules.*'        => 'integer|exists:schedules,sched_id',
            'discount_conditions.accommodation'      => 'nullable|array',
            'discount_conditions.accommodation.*'    => 'integer|exists:passenger_accommodations,accommodation_id',
            'discount_conditions.passenger'          => 'nullable|array',
            'discount_conditions.passenger.*.id'     => 'required_with:discount_conditions.passenger|integer|exists:passenger_types,p_id',
            'discount_conditions.passenger.*.pax'    => 'required_with:discount_conditions.passenger|integer|min:1',
        ])->validate();
    }

    private function generateDiscountCN(): string
    {
        $now = Carbon::now();

        $count = Discount::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->lockForUpdate()
            ->count();

        if ($count >= 100) {
            throw new Exception('Maximum of 100 discounts per month reached (00–99).');
        }

        $yearHex  = strtoupper(dechex($now->year));
        $monthHex = strtoupper(str_pad(dechex($now->month), STR_PAD_LEFT)); // 👈 fixed: was missing length, pad string, and pad type
        $decimal  = str_pad($count, 2, '0', STR_PAD_LEFT);

        return $yearHex . $monthHex . '-' . $decimal;
    }

    private function generateConditions(int $discountId, array $conditions): void
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
                'discount_id'   => $discountId,
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
            DiscountCondition::insert($rows);
        }
    }
}