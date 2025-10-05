<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PassengerCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'p_ctgry_id';

    protected $fillable = [
        'category',
    ];

    public $timestamps = true;
}
