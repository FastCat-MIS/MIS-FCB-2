<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cancellation_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vessel_id')->constrained('vessels')->cascadeOnDelete();
            $table->unsignedBigInteger('schedule_id');
            $table->foreign('schedule_id')->references('sched_id')->on('schedules')->cascadeOnDelete();
            $table->foreignId('vessel_master_id')->constrained('users')->cascadeOnDelete();
            $table->integer('num_passengers_affected');
            $table->integer('num_rcs_affected');
            $table->decimal('est_revenue_loss', 15, 2);
            $table->string('cancellation_category');
            $table->string('cancellation_type');
            $table->string('consulted_dept');
            $table->text('reason_of_cancel');
            $table->text('recommendation')->nullable();
            $table->json('documents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancellation_reports');
    }
};
