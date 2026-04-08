<?php

namespace App\Models\Operations;

use App\Models\Accounts\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vdar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vdar';

    protected $fillable = [
        'vessel_id',
        'schedule_id',
        'vessel_master_id',
        'voyage_number',
        'recorded_sailing_speed',
        'water_consumption',
        'fuel_rob',
        'reason_of_delay',
        'actual_departure_time',
        'actual_arrival_time',
        'ram_disengage_time',
        'undock_time',
    ];

    protected $casts = [
        'actual_departure_time' => 'string',
        'actual_arrival_time'   => 'string',
        'ram_disengage_time'    => 'string',
        'undock_time'           => 'integer',
    ];

    public function vessel()
    {
        return $this->belongsTo(Vessel::class, 'vessel_id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'sched_id');
    }

    public function vesselMaster()
    {
        return $this->belongsTo(User::class, 'vessel_master_id');
    }
}
