<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;

class VehicleGroup extends Model
{
    protected $primaryKey = 'group_id';
    protected $fillable = ['label'];

    public function types()
    {
        return $this->hasMany(VehicleType::class, 'group_id');
    }
}
