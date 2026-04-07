<?php

namespace App\Actions\Operations\Vdar;

use App\Actions\Action;
use App\Models\Accounts\User;
use App\Models\Operations\Vdar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateVdarAction extends Action
{
    public function execute(Vdar $vdar, array $data)
    {
        $validator = Validator::make($data, [
            'vessel_id'              => 'sometimes|exists:vessels,id',
            'schedule_id'            => 'sometimes|exists:schedules,sched_id',
            'vessel_master_id'       => ['sometimes', 'exists:users,id', function ($attribute, $value, $fail) {
                $user = User::find($value);
                if (!$user || !$user->hasRole('Vessel Master')) {
                    $fail('The selected vessel master must have the Vessel Master role.');
                }
            }],
            'voyage_number'          => 'sometimes|integer|min:1',
            'recorded_sailing_speed' => 'sometimes|integer|min:0',
            'water_consumption'      => 'sometimes|integer|min:0',
            'fuel_rob'               => 'sometimes|integer|min:0',
            'reason_of_delay'        => 'nullable|string|max:255',
            'actual_departure_time'  => 'nullable|date_format:H:i:s',
            'actual_arrival_time'    => 'nullable|date_format:H:i:s',
            'ram_disengage_time'     => 'nullable|date_format:H:i:s',
            'undock_time'            => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $vdar->update($validator->validated());

        return $this->success([
            'vdar' => $vdar->fresh()->load([
                'schedule:sched_id,departure_time,arrival_time',
                'vesselMaster:id,first_name,middle_name,last_name',
            ])
        ], 'VDAR updated successfully.');
    }
}
