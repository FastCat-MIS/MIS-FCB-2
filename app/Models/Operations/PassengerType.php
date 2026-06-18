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
        'discount',
        'waived',
        'has_seat',
        'status',
    ];

    protected $casts = [
        'discount' => 'decimal:2',
        'waived' => 'boolean',
        'has_seat' => 'boolean',
    ];

    public $timestamps = true;
}
