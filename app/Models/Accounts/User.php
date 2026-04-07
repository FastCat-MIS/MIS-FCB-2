<?php

namespace App\Models\Accounts;

use App\Models\Operations\Vdar;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles; // Add this import
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected string $guard_name = 'api';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'phone',
        'address',
        'role_id',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Accessor for full name including middle name
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    // Accessor for full name without middle name
    public function getShortNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function vdars()
    {
        return $this->hasMany(Vdar::class, 'vessel_master_id');
    }

    public function getJWTCustomClaims()
    {
        return [
            'user_id' => $this->id,
            'full_name' => $this->full_name,
            'short_name' => $this->short_name,
            'email' => $this->email,
            'role_id' => $this->role_id,
        ];
    }
}
