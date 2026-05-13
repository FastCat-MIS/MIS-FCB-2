<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemClient extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'teller_booking';
    protected $primaryKey = 'pem_client_id';

    protected $fillable = [
        'client_name',
        'pem_public_key',
        'pem_fingerprint',
        'permissions',
        'is_active',
        'last_used_at',
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
    ];

    public function hasPermission(string $endpoint): bool
    {
        if (empty($this->permissions)) {
            return false;
        }

        return in_array($endpoint, $this->permissions) || in_array('*', $this->permissions);
    }

    public function markAsUsed(): void
    {
        $this->update(['last_used_at' => now()]);
    }
}
