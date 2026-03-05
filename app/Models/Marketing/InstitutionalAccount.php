<?php

namespace App\Models\Marketing;

use App\Models\Marketing\Discounts\IADiscount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class InstitutionalAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'ia_id';

    protected $fillable = [
        'ia_name',
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

    public function iaDiscounts()
    {
        return $this->hasMany(IADiscount::class, 'ia_id', 'ia_id');
    }
}
