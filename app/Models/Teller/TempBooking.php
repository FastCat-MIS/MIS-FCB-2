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
        return $this->hasMany(BookedPassenger::class, 'temp_booking_id', 'temp_booking_id');
    }

    public function vehicles()
    {
        return $this->hasMany(BookedVehicle::class, 'temp_booking_id', 'temp_booking_id');
    }
}
