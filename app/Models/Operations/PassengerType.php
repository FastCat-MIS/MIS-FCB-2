<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PassengerType extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'p_id';

    protected $fillable = [
        'type',
        'discount_id',
    ];

    public $timestamps = true;

    public function discount()
    {
        return $this->belongsTo(\App\Models\Marketing\Discount::class, 'discount_id', 'discount_id');
    }
}
