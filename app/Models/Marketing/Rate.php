<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Operations\Route;

class Rate extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'rate_id';

    protected $fillable = [
        'route_id',
        'seat_class',
        'base_rate',
        'effective_date',
        'status',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'status' => 'string',
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
