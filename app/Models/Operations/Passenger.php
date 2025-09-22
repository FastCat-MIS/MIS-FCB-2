<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marketing\Discount;

class Passenger extends Model
{
    use HasFactory;

    protected $primaryKey = 'passenger_id';

    protected $fillable = [
        'booking_id',
        'fullname',
        'discount_id',
        'amount',
        'vehicle_amount',
        'category',
        'type',
        'accommodation',
        'gender',
        'seat'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function getTotalAmountAttribute()
    {
        return $this->amount + $this->vehicle_amount;
    }
}
