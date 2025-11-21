<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'route_id';
    protected $fillable = ['port_a_id', 'port_b_id'];

    public function portA()
    {
        return $this->belongsTo(Port::class, 'port_a_id', 'port_id');
    }

    public function portB()
    {
        return $this->belongsTo(Port::class, 'port_b_id', 'port_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'route_id', 'route_id');
    }

    public function getRouteNameAttribute()
    {
        return "{$this->portA?->port_name} - {$this->portB?->port_name}";
    }
}
