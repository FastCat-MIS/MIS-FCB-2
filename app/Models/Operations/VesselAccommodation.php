<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VesselAccommodation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vessel_id',
        'accommodation_id',
        'rows',
        'columns',
        'aircon',
        'wifi',
        'seats', 
    ];

    protected $hidden = ['seats']; 

    public function seats()
    {
        return $this->hasMany(VesselSeat::class, 'vessel_accommodation_id', 'id');
    }

    public function facilityLabels()
    {
        return $this->hasMany(VesselFacilityLabel::class, 'vessel_accommodation_id', 'id');
    }

    public function accommodation()
    {
        return $this->belongsTo(PassengerAccommodation::class, 'accommodation_id', 'accommodation_id');
    }
}
