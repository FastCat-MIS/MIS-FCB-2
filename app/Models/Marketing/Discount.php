<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'discount_id';

    protected $fillable = [
        'discount_type',
        'discount_code',
        'discount_percentage',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function passengers()
    {
        return $this->hasMany(Passenger::class, 'discount_id');
    }

    public function getIsValidAttribute()
    {
        $now = now();
        return $this->is_active &&
               (!$this->start_date || $this->start_date <= $now) &&
               (!$this->end_date || $this->end_date >= $now);
    }
}
