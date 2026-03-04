<?php

namespace App\Models\Operations;

use App\Models\Marketing\Discounts\Discount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookedPassenger extends Model
{
    use SoftDeletes;

    protected $table = 'booked_passengers';
    protected $primaryKey = 'passenger_id';

    protected $fillable = [
        'booking_id',
        'fullname',
        'discount_id',
        'amount',
        'vehicle_amount',
        'category',
        'type',
        'accommodation_id',
        'gender',
        'seat',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id', 'discount_id');
    }

    public function accommodation()
    {
        return $this->belongsTo(PassengerAccommodation::class, 'accommodation_id', 'accommodation_id');
    }
}
