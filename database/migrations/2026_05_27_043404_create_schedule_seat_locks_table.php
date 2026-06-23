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
        Schema::connection($this->connection)->create('schedule_seat_locks', function (Blueprint $table) {
            $table->id('lock_id');
            
            // What seat is locked?
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('seat_id');
            
            // Identifiers: WHO and WHY?
            $table->string('serial_no', 50);
            $table->unsignedBigInteger('locked_by_user_id')->nullable();
            $table->enum('locked_by_type', ['teller', 'public', 'mobile', 'admin', 'api'])->default('teller');
            
            // When?
            $table->timestamp('locked_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            
            // Indexes for performance
            $table->unique(['schedule_id', 'seat_id'], 'unique_schedule_seat');
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
        Schema::connection($this->connection)->dropIfExists('schedule_seat_locks');
    }
};
