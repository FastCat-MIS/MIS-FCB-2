<?php

namespace App\Actions\Operations\VesselLayout;

use App\Models\Operations\Vessel;

class GetVesselLayoutAction
{
    public function execute(Vessel $vessel)
    {
        return [
            'name' => $vessel->vessel_name,
            'status' => $vessel->status,
            'classes' => $vessel->accommodations->map(function ($accom) {
                return [
                    'name' => $accom->accommodation->accommodation_name,
                    'rows' => $accom->rows,
                    'columns' => $accom->columns,
                    'aircon' => (bool) $accom->aircon,
                    'wifi' => (bool) $accom->wifi,
                    'seats' => $accom->seats()->get()->map(function ($seat) {
                        return [
                            'seat_no' => $seat->seat_no,
                            'row' => $seat->row,
                            'col' => $seat->col,
                            'blocked' => (bool) $seat->blocked,
                            'path' => (bool) $seat->path,
                            'pwd' => (bool) $seat->pwd,
                            'facility' => $seat->facility,
                        ];
                    }),
                    'facilityLabels' => $accom->facilityLabels()->get()->map(function ($label) {
                        return [
                            'name' => $label->name,
                            'top' => $label->top,
                            'left' => $label->left,
                            'width' => $label->width,
                            'height' => $label->height,
                        ];
                    }),
                ];
            }),
        ];
    }
}
