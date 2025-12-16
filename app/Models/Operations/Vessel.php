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
}
