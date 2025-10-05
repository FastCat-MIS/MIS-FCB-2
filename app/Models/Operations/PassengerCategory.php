<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassengerCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'p_ctgry_id';

    protected $fillable = [
        'category',
    ];

    public $timestamps = true;
}
