<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $primaryKey = 'rate_id';

    protected $fillable = [
        'route_id',
        'seat_class',
        'base_rate',
        'effective_date'
    ];

    protected $casts = [
        'effective_date' => 'date'
    ];

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function getFormattedRateAttribute()
    {
        return '₱' . number_format($this->base_rate, 2);
    }
}
