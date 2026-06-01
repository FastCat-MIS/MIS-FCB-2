<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Temporary Booked Passenger Model
 * 
 * Represents a passenger on a pending booking before payment. Data is transferred
 * to PermanentBookedPassenger model when payment is completed.
 * 
 * Database: teller_booking
 * Table: temp_booked_passengers
 * Primary Key: booked_passenger_id
 */
class BookedPassenger extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'teller_booking';

    protected $table = 'temp_booked_passengers';

    protected $primaryKey = 'booked_passenger_id';

    protected $fillable = [
        'temp_booking_id',
        'fullname',
        'gender',
        'passenger_type_id',
        'passenger_type_snapshot',
        'passenger_category_id',
        'passenger_category_snapshot',
        'seat_id',
        'seat_number_snapshot',
        'fare',
        'convenience_fee',
        'discount_amount',
        'discount_id',
        'created_by',
        'expires_at',
    ];

    protected $casts = [
        'fare' => 'decimal:2',
        'convenience_fee' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    public function tempBooking()
    {
        return $this->belongsTo(TempBooking::class, 'temp_booking_id', 'temp_booking_id');
    }
}
