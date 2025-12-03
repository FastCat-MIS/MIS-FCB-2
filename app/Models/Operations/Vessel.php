<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vessel extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'vessel_name',
        'capacity',
        'description',
        'status'
    ];

    protected $with = ['accommodations'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'vessel_id');
    }

    public function accommodations()
    {
        return $this->hasMany(VesselAccommodation::class, 'vessel_id', 'id')
                    ->with('accommodation');
    }

    public $timestamps = true;
}
