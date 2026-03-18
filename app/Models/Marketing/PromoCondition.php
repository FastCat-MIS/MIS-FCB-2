<?php

namespace App\Models\Marketing;

use App\Models\Operations\PassengerAccommodation;
use App\Models\Operations\PassengerType;
use App\Models\Operations\Port;
use App\Models\Operations\Route;
use App\Models\Operations\Schedule;
use App\Models\Operations\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCondition extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'promo_condition_id';
    protected $table = 'promo_conditions';

    protected $fillable = [
        'promo_id',
        'vehicle_id',
        'route_id',
        'port_id',
        'sched_id',
        'ptype_id',
        'pax',
    ];

    public function promo()
    {
        return $this->belongsTo(Promo::class, 'promo_id', 'promo_id');
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
