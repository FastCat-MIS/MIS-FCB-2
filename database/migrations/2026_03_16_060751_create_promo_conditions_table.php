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
        Schema::create('promo_conditions', function (Blueprint $table) {
            $table->id('promo_condition_id');
            $table->foreignId("promo_id")->constrained("promos", "promo_id")->onDelete("cascade");
            $table->foreignId("vehicle_id")->nullable()->constrained("vehicles", "vehicle_id")->onDelete("cascade");
            $table->foreignId("port_id")->nullable()->constrained("ports", "port_id")->onDelete("cascade");
            $table->foreignId("sched_id")->nullable()->constrained("schedules", "sched_id")->onDelete("cascade");
            $table->foreignId("accommodation_id")->nullable()->constrained("passenger_accommodations", "accommodation_id")->onDelete("cascade");
            $table->foreignId("ptype_id")->nullable()->constrained("passenger_types", "p_id")->onDelete("cascade");
            $table->unsignedInteger('pax')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_conditions');
    }
};
