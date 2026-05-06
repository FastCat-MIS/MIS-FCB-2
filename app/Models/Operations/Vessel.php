<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    use HasFactory;

    protected $fillable = [
        'vessel_name',
        'capacity',
        'decklane_length_capacity',
        'weight_capacity',
        'description',
        'status',
    ];


    public function accommodations()
    {
        return $this->hasMany(VesselAccommodation::class, 'vessel_id', 'id')
                    ->with(['seats', 'facilityLabels', 'accommodation']);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'vessel_id');
    }

    public function vdars()
    {
        return $this->hasMany(Vdar::class, 'vessel_id');
    }

    // Optional but recommended
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }
}
