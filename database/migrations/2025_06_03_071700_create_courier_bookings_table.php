<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courier_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained();
            $table->foreignId('sender_id')->constrained('customers');
            $table->foreignId('receiver_id')->constrained('customers');
            $table->foreignId('category_id')->constrained('courier_categories');
            $table->string('tracking_number')->unique();
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('volume', 8, 2)->nullable();
            $table->text('description');
            $table->decimal('shipping_charge', 8, 2);
            $table->decimal('total_amount', 8, 2);
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('status', ['booked', 'in_transit', 'delivered', 'returned', 'cancelled'])->default('booked');
            $table->string('otp')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courier_bookings');
    }
};
