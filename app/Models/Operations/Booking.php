<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'sched_id',
        'booking_number',
        'booking_date',
        'booking_source',
        'vehicle_id',
        'plate_number',
        'is_connecting_trip',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'is_connecting_trip' => 'boolean',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'sched_id', 'sched_id');
    }
}
