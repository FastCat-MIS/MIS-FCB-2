<?php

namespace App\Models\Marketing\Discounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'discount_id';

    protected $fillable = [
        'discount_name',
        'discount_code',
        'discount_value',
        'discount_type',
        'effective_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'end_date' => 'date',
    ];
}
