<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class InstitutionalAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'ia_id';

    protected $fillable = [
        'ia_name',
        'ia_image',
    ];
}
