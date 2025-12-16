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
        'seats', // optional, can remove from fillable if unused
    ];

    protected $hidden = ['seats']; // hide the int column from JSON output

    // Seats relation
    public function seats()
    {
        return $this->hasMany(VesselSeat::class, 'vessel_accommodation_id', 'id');
    }

    // Facility labels relation
    public function facilityLabels()
    {
        return $this->hasMany(VesselFacilityLabel::class, 'vessel_accommodation_id', 'id');
    }

    // Accommodation (passenger type) relation
    public function accommodation()
    {
        return $this->belongsTo(PassengerAccommodation::class, 'accommodation_id', 'accommodation_id');
    }
}
