<?php

namespace App\Models\Marketing\Discounts;

use App\Models\Operations\Route;
use Illuminate\Database\Eloquent\Model;

class IADiscount extends Model
{
    protected $primaryKey = 'ia_discount_id';
    protected $fillable = [
        'ia_id',
        'route_id',
        'discount_value',
        'effective_date',
        'status',
        ];
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }
}
