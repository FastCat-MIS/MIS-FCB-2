<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddOn extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'add_on_id';

    protected $fillable = [
        'add_on_name',
        'value',
        'value_type',
        'operator',
    ];

}