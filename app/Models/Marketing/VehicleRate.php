<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Operations\Route;
use App\Models\Operations\Vehicle;

class VehicleRate extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'vehicle_rate_id';

    protected $fillable = [
      'vehicle_id',
      'route_id',
      'vehicle_rate',
      'effective_date',
      'status',
      
    ];

    protected $casts = [
        'effective_date' => 'date',
        'status' => 'string',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }

    public function vehicle()
    {
      return $this->belongsTo(Vehicle::class,'vehicle_id','vehicle_id');
    }

}
