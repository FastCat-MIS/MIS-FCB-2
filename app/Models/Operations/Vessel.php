<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'vessel_name',
        'capacity',
        'description',
        'status',
    ];

    protected $with = ['accommodations'];

    public function accommodations()
    {
        return $this->hasMany(VesselAccommodation::class, 'vessel_id', 'id')
                    ->with(['seats', 'facilityLabels', 'accommodation']);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'vessel_id');
    }

    // Optional but recommended
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }
}
