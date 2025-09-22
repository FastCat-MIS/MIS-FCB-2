<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id('rate_id');
            $table->foreignId('route_id')->constrained('routes', 'route_id')->onDelete('cascade');
            $table->string('seat_class', 50);
            $table->decimal('base_rate', 10, 2);
            $table->timestamp('effective_date');
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index('route_id');
            $table->index('seat_class');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
