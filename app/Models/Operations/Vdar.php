<?php

namespace App\Models\Operations;

use App\Models\Accounts\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vdar extends Model
{
    use HasFactory;

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
        'actual_departure_time' => 'datetime',
        'actual_arrival_time'   => 'datetime',
        'ram_disengage_time'    => 'datetime',
        'undock_time'           => 'datetime',
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
