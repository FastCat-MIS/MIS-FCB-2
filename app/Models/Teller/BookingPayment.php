<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'teller_booking';

    protected $table = 'booking_payments';

    protected $primaryKey = 'booking_payment_id';

    protected $fillable = [
        'booking_id',
        'total_fare',
        'total_discount',
        'grand_total',
        'total_admin_fee',
        'payment_method',
        'reference_number',
        'created_by',
    ];

    protected $casts = [
        'total_fare' => 'decimal:2',
        'total_discount' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'total_admin_fee' => 'decimal:2',
    ];

    public function bookedPassengers()
    {
        return $this->hasMany(PermanentBookedPassenger::class, 'booking_id', 'booking_id');
    }

    public function bookedVehicles()
    {
        return $this->hasMany(PermanentBookedVehicle::class, 'booking_id', 'booking_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\Accounts\User::class, 'created_by', 'id');
    }
}

