<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $connection = 'teller_booking';
    protected $table = 'bookings';
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'booking_number',
        'schedule_booking_id',
        'is_return_trip',
        'travel_date',
        'schedule_id',
        'schedule_snapshot',
        'route_id',
        'route_snapshot',
        'vessel_snapshot',
        'institutional_account_id',
        'institutional_account_snapshot',
        'booking_origin',
        'created_by',
    ];

    protected $casts = [
        'is_return_trip' => 'boolean',
        'travel_date' => 'date',
        'schedule_snapshot' => 'datetime:H:i:s',
        'route_snapshot' => 'array',
        'vessel_snapshot' => 'array',
        'institutional_account_snapshot' => 'array',
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
