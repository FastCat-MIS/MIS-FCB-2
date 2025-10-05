<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marketing\Rate;
use Illuminate\Database\Eloquent\SoftDeletes;
class Route extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'route_id';

    protected $fillable = [
        'port_a',
        'port_b',
    ];

    public $timestamps = true;

    public function getRouteKeyName()
    {
        return 'route_id';
    }

    // public function rates()
    // {
    //     return $this->hasMany(Rate::class, 'route_id');
    // }

    // public function schedules()
    // {
    //     return $this->hasMany(Schedule::class, 'route_id');
    // }

    public function getRouteNameAttribute()
    {
        return "{$this->port_a} - {$this->port_b}";
    }
}
