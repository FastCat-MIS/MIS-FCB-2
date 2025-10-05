<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class VehicleType extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'type_id';
    protected $fillable = ['group_id', 'label', 'type_code'];

    public function group()
    {
        return $this->belongsTo(VehicleGroup::class, 'group_id');
    }

    public function brands()
    {
        return $this->hasMany(VehicleBrand::class, 'type_id');
    }

    public $timestamps = true;
}
