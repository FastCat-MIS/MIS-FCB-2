<?php

namespace App\Models\Marketing;

use App\Models\Marketing\Discounts\MerchantDiscount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Merchant extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'merchant_id';

    protected $fillable = [
        'merchant_name',
        'image',
        'address',
        'email',
        'password',
        'contact_number',
        'contact_person',
        'area',
        'payment_mode',
        'payment_type',
        'status',
        'effective_date',
        'eoc_date',
    ];

    protected $hidden = [
        'password'
    ];

    public function merchantDiscounts()
    {
        return $this->hasMany(MerchantDiscount::class, 'merchant_id', 'merchant_id');
    }
}
