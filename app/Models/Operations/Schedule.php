<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'sched_id';

    protected $fillable = [
        'departure_time',
        'route_id',
        'vessel_id',
        'status'
    ];

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }

    public function vessel()
    {
        return $this->belongsTo(\App\Models\Operations\Vessel::class, 'vessel_id', 'id');
    }
}
