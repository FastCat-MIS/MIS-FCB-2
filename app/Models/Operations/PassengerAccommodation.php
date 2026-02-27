<?php

namespace App\Models\Operations;

use App\Models\Marketing\AccommodationRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PassengerAccommodation extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'accommodation_id';

    protected $fillable = [
        'accommodation_name',
    ];

    public $timestamps = true;

    public function vesselAccommodations()
    {
        return $this->hasMany(VesselAccommodation::class, 'accommodation_id', 'accommodation_id');
    }

    public function accommodationRates()
    {
        return $this->hasMany(AccommodationRate::class,'accommodation_id','accommodation_id');
    }

}
