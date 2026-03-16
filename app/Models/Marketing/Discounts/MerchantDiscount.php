<?php

namespace App\Models\Marketing\Discounts;

use App\Models\Marketing\Merchant;
use App\Models\Operations\Route;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantDiscount extends Model
{

    use HasFactory, SoftDeletes;

    protected $primaryKey = 'merchant_discount_id';  
    protected $table = 'merchant_discounts';

    protected $fillable = [
        'merchant_id',
        'route_id',
        'discount_name',
        'discount_value',
        'value_type',
        'effective_date',
        'status',
        ];
        
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }
    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'merchant_id');
    }
}
