<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Account\User;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'sched_id',
        'booking_number',
        'booking_date',
        'booking_source',
        'user_id',
        'vehicle_id',
        'plate_number',
        'is_connecting_trip',
        'total_amount',
        'status'
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'is_connecting_trip' => 'boolean'
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'sched_id');
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class, 'booking_id');
    }

    public function connectingTrips()
    {
        return $this->hasMany(ConnectingTrip::class, 'booking_number', 'booking_number');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public $timestamps = true;
}

