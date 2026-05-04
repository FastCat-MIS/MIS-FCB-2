<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookedVehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'teller_booking';

    protected $table = 'booked_vehicles';

    protected $primaryKey = 'booked_vehicle_id';

    protected $fillable = [
        'serial_no',
        'booking_id',
        'schedule_booking_id',
        'is_return_trip',
        'travel_date',
        'schedule_id',
        'schedule_snapshot',
        'route_id',
        'route_snapshot',
        'vehicle_type',
        'plate_no',
        'length',
        'weight',
        'fare',
        'driver_passenger_booking_id',
        'institutional_account_id',
    ];

    protected $casts = [
        'is_return_trip' => 'boolean',
        'travel_date' => 'date:Y-m-d',
        'schedule_snapshot' => 'string',
        'length' => 'decimal:2',
        'weight' => 'decimal:2',
        'fare' => 'decimal:2',
    ];

    public function payment()
    {
        return $this->belongsTo(BookingPayment::class, 'booking_id', 'booking_id');
    }
}

