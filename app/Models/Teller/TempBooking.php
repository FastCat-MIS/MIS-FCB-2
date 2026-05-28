<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Model;

class TempBooking extends Model
{
    protected $connection = 'teller_booking';
    protected $table = 'temp_bookings';
    protected $primaryKey = 'temp_booking_id';

    protected $fillable = [
        'serial_no',
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
        return $this->hasMany(BookedPassenger::class, 'temp_booking_id', 'temp_booking_id');
    }

    public function vehicles()
    {
        return $this->hasMany(BookedVehicle::class, 'temp_booking_id', 'temp_booking_id');
    }
}
