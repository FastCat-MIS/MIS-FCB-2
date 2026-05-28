<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Model;

class ScheduleSeatLock extends Model
{
    protected $connection = 'teller_booking';
    protected $table = 'schedule_seat_locks';
    protected $primaryKey = 'id'; // ← Changed from lock_id
    
    public $timestamps = false; // Using custom locked_at

    protected $fillable = [
        'schedule_id',
        'seat_id',
        'travel_date',
        'vessel_id',
        'vessel_snapshot',
        'serial_no',
        'locked_by_user_id',
        'locked_by_type',
        'locked_at',
        'expires_at',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'locked_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Scope to get only active (non-expired) locks
     * Includes permanent locks (expires_at = null) and temp locks that haven't expired
     */
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expires_at') // Permanent locks (after payment)
              ->orWhere('expires_at', '>', now()); // Active temp locks
        });
    }

    /**
     * Scope to get expired locks (temp locks only)
     */
    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')
                     ->where('expires_at', '<=', now());
    }

    /**
     * Scope to get permanent locks (completed bookings)
     */
    public function scopePermanent($query)
    {
        return $query->whereNull('expires_at');
    }

    /**
     * Scope to get temporary locks (pending bookings)
     */
    public function scopeTemporary($query)
    {
        return $query->whereNotNull('expires_at');
    }

    /**
     * Check if lock is expired
     */
    public function isExpired(): bool
    {
        if ($this->expires_at === null) {
            return false; // Permanent locks never expire
        }
        return $this->expires_at <= now();
    }

    /**
     * Check if lock is permanent (completed booking)
     */
    public function isPermanent(): bool
    {
        return $this->expires_at === null;
    }

    /**
     * Get remaining time in minutes
     */
    public function getRemainingMinutesAttribute(): ?int
    {
        if ($this->expires_at === null) {
            return null; // Permanent locks have no expiration
        }
        return max(0, now()->diffInMinutes($this->expires_at, false));
    }
}
