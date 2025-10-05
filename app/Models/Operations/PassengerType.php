<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassengerType extends Model
{
    use HasFactory;

    protected $primaryKey = 'p_id';

    protected $fillable = [
        'type',
    ];

    public $timestamps = true;
}
