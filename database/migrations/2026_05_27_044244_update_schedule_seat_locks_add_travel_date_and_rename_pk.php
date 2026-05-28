<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_booking';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop and recreate with correct structure
        Schema::connection($this->connection)->dropIfExists('schedule_seat_locks');
        
        Schema::connection($this->connection)->create('schedule_seat_locks', function (Blueprint $table) {
            $table->id(); // Uses 'id' by default
            
            // What seat is locked?
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('seat_id');
            $table->date('travel_date'); // ← Added for multi-date support
            
            // Identifiers: WHO and WHY?
            $table->string('serial_no', 50);
            $table->unsignedBigInteger('locked_by_user_id')->nullable();
            $table->enum('locked_by_type', ['teller', 'public', 'mobile', 'admin', 'api'])->default('teller');
            
            // When?
            $table->timestamp('locked_at')->useCurrent();
            $table->timestamp('expires_at');
            
            // Indexes for performance
            $table->unique(['schedule_id', 'seat_id', 'travel_date'], 'unique_schedule_seat_date'); // ← Updated constraint
            $table->index('serial_no', 'idx_serial_no');
            $table->index(['locked_by_user_id', 'locked_by_type'], 'idx_user');
            $table->index('expires_at', 'idx_expires');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore old structure (without travel_date)
        Schema::connection($this->connection)->dropIfExists('schedule_seat_locks');
        
        Schema::connection($this->connection)->create('schedule_seat_locks', function (Blueprint $table) {
            $table->id('lock_id');
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('seat_id');
            $table->string('serial_no', 50);
            $table->unsignedBigInteger('locked_by_user_id')->nullable();
            $table->enum('locked_by_type', ['teller', 'public', 'mobile', 'admin', 'api'])->default('teller');
            $table->timestamp('locked_at')->useCurrent();
            $table->timestamp('expires_at');
            $table->unique(['schedule_id', 'seat_id'], 'unique_schedule_seat');
            $table->index('serial_no', 'idx_serial_no');
            $table->index(['locked_by_user_id', 'locked_by_type'], 'idx_user');
            $table->index('expires_at', 'idx_expires');
        });
    }
};
