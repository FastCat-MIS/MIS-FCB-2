<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Account\User;
use App\Models\Operations\Vessel;

class Schedule extends Model
{
    use HasFactory;

    protected $primaryKey = 'schedule_id';

    protected $fillable = [
        'route_id',
        'vessel_id',
        'departure_time',
        'arrival_time',
        'status'
    ];

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'schedule_id');
    }

    public function connectingTrips()
    {
        return $this->hasMany(ConnectingTrip::class, 'schedule_id');
    }

    public function vessel()
    {
        return $this->belongsTo(Vessel::class, 'vessel_id', 'vessel_id');
    }
}
