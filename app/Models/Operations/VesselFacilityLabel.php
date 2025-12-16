<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;

class VesselFacilityLabel extends Model
{
    protected $fillable = [
        'vessel_accommodation_id',
        'name',
        'top',
        'left',
        'width',
        'height',
    ];

    public function accommodation()
    {
        return $this->belongsTo(VesselAccommodation::class, 'vessel_accommodation_id');
    }
}
