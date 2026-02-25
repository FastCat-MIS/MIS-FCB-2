<?php

namespace App\Models\Operations;

use App\Models\Marketing\VehicleRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $primaryKey = 'vehicle_id';
    protected $fillable = [
      'vehicle_type',
      'vehicle_class',
    ];

    public function vehicleRates()
    {
       return $this->hasMany(VehicleRate::class, 'vehicle_id', 'vehicle_id');
    }


}
