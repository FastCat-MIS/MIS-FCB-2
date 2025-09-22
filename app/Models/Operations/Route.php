<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marketing\Rate;

class Route extends Model
{
    use HasFactory;

    protected $primaryKey = 'route_id';

    protected $fillable = [
        'origin',
        'destination'
    ];

    public function rates()
    {
        return $this->hasMany(Rate::class, 'route_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'route_id');
    }

    public function getRouteNameAttribute()
    {
        return "{$this->origin} - {$this->destination}";
    }
}
