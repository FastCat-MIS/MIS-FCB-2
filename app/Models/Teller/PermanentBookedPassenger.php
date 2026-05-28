<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    protected $casts = [
        'fare' => 'decimal:2',
        'discount_amount' => 'decimal:2',
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