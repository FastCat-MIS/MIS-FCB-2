<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookedVehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'teller_booking';

    protected $table = 'temp_booked_vehicles';

    protected $primaryKey = 'booked_vehicle_id';

    protected $fillable = [
        'temp_booking_id',
        'vehicle_type',
        'plate_no',
        'length',
        'weight',
        'fare',
        'driver_passenger_booking_id',
        'created_by',
        'expires_at',
    ];

    protected $casts = [
        'length' => 'decimal:2',
        'weight' => 'decimal:2',
        'fare' => 'decimal:2',
    ];

    public function tempBooking()
    {
        return $this->belongsTo(TempBooking::class, 'temp_booking_id', 'temp_booking_id');
    }
}

