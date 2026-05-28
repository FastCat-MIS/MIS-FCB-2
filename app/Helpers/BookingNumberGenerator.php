<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class BookingNumberGenerator
{
    /**
     * Generate a unique hexadecimal booking number
     * Format: YYYYMMDD-XXXXXXXX (date-8 char hex)
     * Example: 20260527-A3F2E8B1
     * 
     * @return string
     */
    public static function generate(): string
    {
        // Get current date
        $date = now()->format('Ymd');
        
        // Generate 8-character hexadecimal string (4 bytes = 8 hex chars)
        $hex = strtoupper(bin2hex(random_bytes(4)));
        
        return "{$date}-{$hex}";
    }

    /**
     * Generate with custom prefix
     * 
     * @param string $prefix
     * @return string
     */
    public static function generateWithPrefix(string $prefix): string
    {
        $hex = strtoupper(bin2hex(random_bytes(4)));
        return "{$prefix}-{$hex}";
    }
}
