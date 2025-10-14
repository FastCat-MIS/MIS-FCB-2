<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $primaryKey = 'port_id';

    protected $fillable = [
        'port_name',
        'corridor',
        'facilities',
        'last_update_by',
        'is_active',
    ];
}
