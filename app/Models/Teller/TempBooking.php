<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Model;

/**
 * Temporary Booking Model
 * 
 * Represents a pending booking in the teller system before payment is completed.
 * Uses serial_no for identification. Once payment is processed, data is transferred
 * to the permanent Booking model and this record is deleted.
 * 
 * Database: teller_booking
 * Table: temp_bookings
 * Primary Key: temp_booking_id
 */
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

    /**
     * Cast attributes to native types
     * 
     * Note: JSON columns are automatically cast to arrays for easy access
     */
    protected $casts = [
        'is_return_trip' => 'boolean',
        'travel_date' => 'date',
        'schedule_snapshot' => 'datetime:H:i:s',
        'route_snapshot' => 'array',
        'vessel_snapshot' => 'array',
        'institutional_account_snapshot' => 'array',
    ];

    /**
     * Relationships
     */
    
    // Get all temporary passengers associated with this pending booking
    public function passengers()
    {
        return $this->hasMany(BookedPassenger::class, 'temp_booking_id', 'temp_booking_id');
    }

    // Get all temporary vehicles associated with this pending booking
    public function vehicles()
    {
        return $this->hasMany(BookedVehicle::class, 'temp_booking_id', 'temp_booking_id');
    }
}
