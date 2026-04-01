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
        Schema::create('merchant_discounts', function (Blueprint $table) {
            $table->id("merchant_discount_id");
            $table->foreignId("merchant_id")->constrained("merchants", "merchant_id")->onDelete("cascade");
            $table->foreignId("route_id")->constrained("routes", "route_id")->onDelete("cascade");
            $table->string("discount_name", 255)->nullable();
            $table->decimal('discount_value', 10, 2)->default(0.00)->nullable();            
            $table->unsignedTinyInteger('value_type');
            $table->timestamp("effective_date")->nullable();
            $table->unsignedTinyInteger("status")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_discounts');
    }
};
