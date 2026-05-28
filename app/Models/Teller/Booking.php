<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Model;

/**
 * Permanent Booking Model
 * 
 * Represents a completed booking in the teller system. Created after payment
 * is successfully processed. Uses booking_number (format: 7EA5-00001) instead
 * of serial_no which is used for temporary bookings.
 * 
 * Database: teller_booking
 * Table: bookings
 * Primary Key: booking_id
 */
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

    /**
     * Cast attributes to native types
     * 
     * Note: vessel_snapshot and institutional_account_snapshot are JSON columns
     * automatically cast to arrays. route_snapshot is stored as a plain string
     * (e.g., "Batangas Port - Calapan Port") and should not be cast to array.
     */
    protected $casts = [
        'is_return_trip' => 'boolean',
        'travel_date' => 'date',
        'schedule_snapshot' => 'datetime:H:i:s',
        'vessel_snapshot' => 'array',
        'institutional_account_snapshot' => 'array',
    ];

    /**
     * Relationships
     */
    
    // Get all passengers associated with this completed booking
    public function passengers()
    {
        return $this->hasMany(PermanentBookedPassenger::class, 'booking_id', 'booking_id');
    }

    // Get all vehicles associated with this completed booking
    public function vehicles()
    {
        return $this->hasMany(PermanentBookedVehicle::class, 'booking_id', 'booking_id');
    }

    // Get the payment record for this booking
    public function payment()
    {
        return $this->hasOne(BookingPayment::class, 'booking_id', 'booking_id');
    }
}
