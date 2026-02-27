<?php

namespace App\Models\Marketing;

use App\Models\Operations\PassengerAccommodation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Operations\Route;
use App\Models\Operations\VesselAccommodation;


class AccommodationRate extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'acc_rate_id';

    protected $fillable = [
        'route_id',
        'accommodation_id',
        'base_rate',
        'effective_date',
        'status'
    ];
        protected $casts = [
        'effective_date' => 'date',
        'status' => 'string',
    ];
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }

    public function accommodation()
    {
        return $this->belongsTo(PassengerAccommodation::class,'accommodation_id', 'accommodation_id');
    }
    
}
