<?php

namespace App\Models\Marketing\Discounts;

use App\Models\Marketing\InstitutionalAccount;
use App\Models\Operations\Route;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IADiscount extends Model
{

    use HasFactory, SoftDeletes;

    protected $primaryKey = 'ia_discount_id';  
    protected $table = 'ia_discounts';

    protected $fillable = [
        'ia_id',
        'route_id',
        'discount_name',
        'discount_value',
        'discount_type',
        'effective_date',
        'status',
        ];
        
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }
    public function institutionalAccount()
    {
        return $this->belongsTo(InstitutionalAccount::class, 'ia_id', 'ia_id');
    }
}
