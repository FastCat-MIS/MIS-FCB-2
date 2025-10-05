<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class VehicleGroup extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'group_id';
    protected $fillable = ['label'];

    public function types()
    {
        return $this->hasMany(VehicleType::class, 'group_id');
    }

    public $timestamps = true;
}
