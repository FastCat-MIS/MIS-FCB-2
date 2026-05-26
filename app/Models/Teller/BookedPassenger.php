<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookedPassenger extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'teller_booking';

    protected $table = 'temp_booked_passengers';

    protected $primaryKey = 'booked_passenger_id';

    protected $fillable = [
        'temp_booking_id',
        'serial_no',
        'booking_id',
        'schedule_booking_id',
        'is_return_trip',
        'fullname',
        'gender',
        'passenger_type_id',
        'passenger_type_snapshot',
        'passenger_category_id',
        'passenger_category_snapshot',
        'seat_id',
        'seat_number_snapshot',
        'agent_id',
        'fare',
        'discount_amount',
        'discount_id',
        'institutional_account_id',
        'created_by',
        'expires_at',
    ];

    protected $casts = [
        'is_return_trip' => 'boolean',
        'fare' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    public function tempBooking()
    {
        return $this->belongsTo(TempBooking::class, 'temp_booking_id', 'temp_booking_id');
    }
}
