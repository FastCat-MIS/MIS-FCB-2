<?php

namespace App\Actions\Operations\Vdar;

use App\Actions\Action;
use App\Models\Operations\Vdar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateVdarAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'vessel_id'              => 'required|exists:vessels,id',
            'schedule_id'            => 'required|exists:schedules,sched_id',
            'vessel_master_id'       => 'required|exists:users,id',
            'voyage_number'          => 'required|integer|min:1',
            'recorded_sailing_speed' => 'required|integer|min:0',
            'water_consumption'      => 'required|integer|min:0',
            'fuel_rob'               => 'required|integer|min:0',
            'reason_of_delay'        => 'nullable|string|max:255',
            'actual_departure_time'  => 'nullable|date_format:H:i:s',
            'actual_arrival_time'    => 'nullable|date_format:H:i:s',
            'ram_disengage_time'     => 'nullable|date_format:H:i:s',
            'undock_time'            => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $vdar = Vdar::create($validator->validated());

        return $this->success([
            'vdar' => $vdar->load([
                'schedule:sched_id,departure_time,arrival_time',
                'vesselMaster:id,first_name,middle_name,last_name',
            ])
        ], 'VDAR created successfully.', 201);
    }
}
