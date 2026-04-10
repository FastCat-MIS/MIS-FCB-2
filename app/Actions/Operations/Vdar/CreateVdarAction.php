<?php

namespace App\Actions\Operations\Vdar;

use App\Actions\Action;
use App\Models\Accounts\User;
use App\Models\Operations\Vdar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateVdarAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'port_id'                => 'required|exists:ports,port_id',
            'vessel_id'              => 'required|exists:vessels,id',
            'schedule_id'            => 'required|exists:schedules,sched_id',
            'vessel_master_id'       => ['required', 'exists:users,id', function ($_attribute, $value, $fail) {
                $user = User::find($value);
                if (!$user || !$user->hasRole('Vessel Master')) {
                    $fail('The selected vessel master must have the Vessel Master role.');
                }
            }],
            'voyage_number'          => 'required|string|max:255',
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

        $validated = $validator->validated();
        $validated['control_number'] = $this->generateControlNumber($validated['port_id']);

        $vdar = Vdar::create($validated);

        return $this->success([
            'vdar' => $vdar->load([
                'port:port_id,port_name',
                'schedule:sched_id,departure_time,arrival_time',
                'vesselMaster:id,first_name,middle_name,last_name',
            ])
        ], 'VDAR created successfully.', 201);
    }

    private function generateControlNumber(int $portId): string
    {
        $now       = now();
        $portPart  = str_pad($portId, 2, '0', STR_PAD_LEFT);
        $yearHex   = strtoupper(dechex($now->year));
        $monthHex  = strtoupper(dechex($now->month));

        $count = Vdar::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        $countPart = str_pad($count, 4, '0', STR_PAD_LEFT);

        return "{$portPart}{$yearHex}{$monthHex}-{$countPart}";
    }
}
