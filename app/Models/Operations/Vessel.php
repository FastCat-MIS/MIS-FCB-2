<?php
// app/Models/Operations/Vessel.php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Vessel extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'vessel_id';

    protected $fillable = [
        'name',
        'capacity',
        'description',
        'status'
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'vessel_id');
    }

    public $timestamps = true;
}
