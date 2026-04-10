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

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'port_id', 'port_id');
    }

    public function vdars()
    {
        return $this->hasMany(Vdar::class, 'port_id', 'port_id');
    }

    public function routesAsPortA()
    {
        return $this->hasMany(Route::class, 'port_a_id', 'port_id');
    }

    public function routesAsPortB()
    {
        return $this->hasMany(Route::class, 'port_b_id', 'port_id');
    }

    public function route()
    {
        return $this->belongsTo(\App\Models\Operations\Route::class, 'route_id', 'route_id');
    }

    }
