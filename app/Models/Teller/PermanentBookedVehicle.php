<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermanentBookedVehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'teller_booking';

    protected $table = 'booked_vehicles';

    protected $primaryKey = 'booked_vehicle_id';

    protected $fillable = [
        'booking_id',
        'serial_no',
        'schedule_booking_id',
        'is_return_trip',
        'vehicle_type',
        'plate_no',
        'length',
        'weight',
        'fare',
        'driver_passenger_booking_id',
        'institutional_account_id',
        'created_by',
        'expires_at',
    ];

    protected $casts = [
        'is_return_trip' => 'boolean',
        'length' => 'decimal:2',
        'weight' => 'decimal:2',
        'fare' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public function payment()
    {
        return $this->belongsTo(BookingPayment::class, 'booking_id', 'booking_id');
    }

    public function driver()
    {
        return $this->belongsTo(PermanentBookedPassenger::class, 'driver_passenger_booking_id', 'booked_passenger_id');
    }
}