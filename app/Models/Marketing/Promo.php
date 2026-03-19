<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'promo_id';

    protected $fillable = [
        'promo_name',
        'promo_cn',
        'promo_code',
        'promo_value',
        'value_type',
        'round_trip',
        'condition',
        'effective_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'end_date' => 'date',
    ];

    public function promoConditions()
    {
    return $this->hasMany(PromoCondition::class, 'promo_id', 'promo_id');
    }
}
