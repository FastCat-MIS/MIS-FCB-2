<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_booking';

    public function up(): void
    {
        Schema::connection($this->connection)->create('booking_payments', function (Blueprint $table) {
            $table->id('booking_payment_id');

            $table->unsignedBigInteger('booking_id');

            $table->decimal('total_fare', 10, 2)->default(0);
            $table->decimal('total_discount', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2)->default(0);
            $table->decimal('total_admin_fee', 10, 2)->default(0);

            $table->string('payment_method', 50);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['booking_id']);
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('booking_payments');
    }
};

