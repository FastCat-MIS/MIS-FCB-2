<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $primaryKey = 'port_id';

    protected $fillable = [
        'port_name',
        'corridor',
        'facilities',
        'last_update_by',
        'is_active',
        'ramp_status',
    ];

    // Port has many schedules
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'port_id', 'port_id');
    }

    // Optional: Routes where this port is port_a
    public function routesAsPortA()
    {
        return $this->hasMany(Route::class, 'port_a_id', 'port_id');
    }

    // Optional: Routes where this port is port_b
    public function routesAsPortB()
    {
        return $this->hasMany(Route::class, 'port_b_id', 'port_id');
    }
}
