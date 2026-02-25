<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;

use App\Models\Marketing\Rate;
use App\Models\Marketing\VehicleRate;

class Route extends Model
{
    protected $primaryKey = 'route_id';

    protected $fillable = [
        'port_a_id',
        'port_b_id',
    ];

    protected $with = ['portA', 'portB'];

    public function portA()
    {
        return $this->belongsTo(Port::class, 'port_a_id', 'port_id');
    }

    public function portB()
    {
        return $this->belongsTo(Port::class, 'port_b_id', 'port_id');
    }

    public function rates()
    {
        return $this->hasMany(Rate::class, 'route_id', 'route_id');
    }

    public function vehicleRates()
    {
        return $this->hasMany(VehicleRate::class,'route_id','route_id');
    }
}
