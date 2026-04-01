<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;

class VesselSeat extends Model
{
    protected $fillable = [
        'vessel_accommodation_id',
        'seat_no',
        'row',
        'col',
        'blocked',
        'path',
        'pwd',
        'facility',
    ];

    protected $casts = [
        'blocked' => 'boolean',
        'path' => 'boolean',
        'pwd' => 'boolean',
    ];

    public function accommodation()
    {
        return $this->belongsTo(VesselAccommodation::class, 'vessel_accommodation_id');
    }
}
