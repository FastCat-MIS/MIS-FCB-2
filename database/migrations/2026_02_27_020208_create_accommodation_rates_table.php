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
        Schema::create('accommodation_rates', function (Blueprint $table) {
            $table->id('acc_rate_id');
            $table->foreignId('route_id')->constrained('routes', 'route_id');
            $table->foreignId('accommodation_id')->constrained('passenger_accommodations', 'accommodation_id'); 
            $table->decimal('base_rate', 10, 2);
            $table->timestamp('effective_date')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index('route_id');
            $table->index('accommodation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodation_rates');
    }
};