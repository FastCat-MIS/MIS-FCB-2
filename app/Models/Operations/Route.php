<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $primaryKey = 'route_id';

    public function portA()
    {
        return $this->belongsTo(Port::class, 'port_a_id', 'port_id');
    }

    public function portB()
    {
        return $this->belongsTo(Port::class, 'port_b_id', 'port_id');
    }
}

