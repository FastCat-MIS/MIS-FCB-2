<?php

namespace App\Models\Marketing\Discounts;

use App\Models\Operations\PassengerAccommodation;
use App\Models\Operations\PassengerType;
use App\Models\Operations\Port;
use App\Models\Operations\Route;
use App\Models\Operations\Schedule;
use App\Models\Operations\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountCondition extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'discount_condition_id';
    protected $table = 'discount_conditions';

    protected $fillable = [
        'discount_id',
        'vehicle_id',
        'route_id',
        'port_id',
        'sched_id',
        'ptype_id',
        'pax',
    ];

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id', 'discount_id');
    }

     public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function accommodation()
    {
        return $this->belongsTo(PassengerAccommodation::class, 'accommodation_id', 'accommodation_id');
    }

    public function passengerType()
    {
        return $this->belongsTo(PassengerType::class, 'ptype_id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'sched_id');
    }

    public function port()
    {
        return $this->belongsTo(Port::class, 'port_id');
    }

}
