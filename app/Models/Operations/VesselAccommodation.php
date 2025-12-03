<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VesselAccommodation extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'vessel_id',
        'accommodation_id',
        'seats',
        'aircon',
        'wifi',
    ];

    public function accommodation()
    {
        return $this->belongsTo(PassengerAccommodation::class, 'accommodation_id', 'accommodation_id');
    }

    public function vessel()
    {
        return $this->belongsTo(Vessel::class, 'vessel_id', 'id');
    }
}
