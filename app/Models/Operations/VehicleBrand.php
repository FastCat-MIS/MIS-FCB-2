<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class VehicleBrand extends Model
{

    use SoftDeletes;
    protected $primaryKey = 'brand_id';
    protected $fillable = ['type_id', 'label'];

    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'type_id');
    }

    public $timestamps = true;
}
