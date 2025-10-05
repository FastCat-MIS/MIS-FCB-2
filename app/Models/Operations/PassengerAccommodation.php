<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PassengerAccommodation extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'accommodation_id';

    protected $fillable = [
        'accommodation_name',
    ];

    public $timestamps = true;
}
