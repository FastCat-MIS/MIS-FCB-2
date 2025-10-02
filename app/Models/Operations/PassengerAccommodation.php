<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassengerAccommodation extends Model
{
    use HasFactory;

    protected $primaryKey = 'accommodation_id';

    protected $fillable = [
        'accommodation_name',
    ];
}
