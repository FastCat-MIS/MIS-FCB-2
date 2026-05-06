<?php

namespace App\Models\Operations;

use App\Models\Marketing\VehicleRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'vehicle_id';
    protected $fillable = [
      'vehicle_type',
      'vehicle_class',
      'weight',
      'length',
      ];

    public function vehicleRates()
    {
       return $this->hasMany(VehicleRate::class, 'vehicle_id', 'vehicle_id');
    }


}
