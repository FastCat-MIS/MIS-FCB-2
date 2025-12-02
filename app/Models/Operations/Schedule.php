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
        'vessel_id',
        'port_id', // link to port
        'status',
    ];

    // Schedule belongs to a vessel
    public function vessel()
    {
        return $this->belongsTo(Vessel::class, 'vessel_id', 'id');
    }

    // Schedule belongs to a port
    public function port()
    {
        return $this->belongsTo(Port::class, 'port_id', 'port_id');
    }
}
