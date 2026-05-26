<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $connection = 'teller_booking';
    protected $table = 'bookings';
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'travel_date',
        'schedule_id',
        'schedule_snapshot',
        'route_id',
        'route_snapshot',
        'origin_port_snapshot',
        'destination_port_snapshot',
        'vessel_snapshot',
        'created_by',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'schedule_snapshot' => 'datetime:H:i:s',
    ];

    // Relationships
    public function passengers()
    {
        return $this->hasMany(PermanentBookedPassenger::class, 'booking_id', 'booking_id');
    }

    public function vehicles()
    {
        return $this->hasMany(PermanentBookedVehicle::class, 'booking_id', 'booking_id');
    }

    public function payment()
    {
        return $this->hasOne(BookingPayment::class, 'booking_id', 'booking_id');
    }
}
