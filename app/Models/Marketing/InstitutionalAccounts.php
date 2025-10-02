<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionalAccount extends Model
{
    use HasFactory;

    protected $primaryKey = 'ia_id';

    protected $fillable = [
        'ia_name',
        'ia_image',
    ];
}
