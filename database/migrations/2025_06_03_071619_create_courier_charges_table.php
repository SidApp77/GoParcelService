<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courier_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained();
            $table->foreignId('category_id')->constrained('courier_categories');
            $table->decimal('base_price', 8, 2);
            $table->decimal('price_per_kg', 8, 2)->nullable();
            $table->decimal('price_per_cc', 8, 2)->nullable();
            $table->decimal('min_charge', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courier_charges');
    }
};
