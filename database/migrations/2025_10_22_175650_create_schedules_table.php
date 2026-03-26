<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id('sched_id'); 
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->foreignId('vessel_id')
            ->nullable()
            ->constrained('vessels', 'id')
            ->nullOnDelete()
            ->cascadeOnUpdate();
            $table->foreignId('port_id')
            ->nullable()
            ->constrained('ports', 'port_id')
            ->nullOnDelete()
            ->cascadeOnUpdate();
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedTinyInteger('visibility')
                  ->default(7)
                  ->comment('0=None, 1=Online, 2=Walk-in, 3=Online/Walk-in, 4=Merchant, 5=Online/Merchant, 6=Merchant/Walk-in, 7=All');
            $table->timestamps();         
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
