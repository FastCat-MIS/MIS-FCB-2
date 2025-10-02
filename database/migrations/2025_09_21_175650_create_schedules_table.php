<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id('sched_id'); // ✅ Use sched_id as specified
            $table->time('departure_time'); // ✅ Only time
            $table->string('vessel');       // ✅ Vessel name as string
            $table->timestamps();           // Optional, but commonly used
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
