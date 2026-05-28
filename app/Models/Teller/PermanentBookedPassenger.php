<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Permanent Booked Passenger Model
 * 
 * Represents a passenger on a completed booking. Created when payment is processed
 * and temp passenger data is transferred to permanent storage. Includes soft deletes
 * for data retention and audit purposes.
 * 
 * Database: teller_booking
 * Table: booked_passengers
 * Primary Key: booked_passenger_id
 */
class PermanentBookedPassenger extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'teller_booking';

    protected $table = 'booked_passengers';

    protected $primaryKey = 'booked_passenger_id';

    protected $fillable = [
        'booking_id',
        'fullname',
        'gender',
        'passenger_type_id',
        'passenger_type_snapshot',
        'passenger_category_id',
        'passenger_category_snapshot',
        'seat_id',
        'seat_number_snapshot',
        'fare',
        'discount_amount',
        'discount_id',
        'created_by',
        'expires_at',
    ];

    /**
     * Cast attributes to native types
     * 
     * Note: Snapshot columns are automatically cast to arrays
     */
    protected $casts = [
        'fare' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'passenger_type_snapshot' => 'array',
        'passenger_category_snapshot' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public function payment()
    {
        return $this->belongsTo(BookingPayment::class, 'booking_id', 'booking_id');
    }
}