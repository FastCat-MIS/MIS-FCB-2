<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectingTrip extends Model
{
    use HasFactory;

    protected $primaryKey = 'connecting_id';

    protected $fillable = [
        'booking_number',
        'sched_id',
        'leg',
        'route'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_number', 'booking_number');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'sched_id');
    }

    public $timestamps = true;
}
