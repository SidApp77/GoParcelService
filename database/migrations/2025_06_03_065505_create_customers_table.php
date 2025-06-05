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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('phone', 20)->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->enum('id_proof_type', ['aadhaar', 'pan', 'driving_license', 'voter_id', 'passport'])->nullable();
            $table->string('id_proof_number', 100)->nullable()->unique();
            $table->string('id_proof_document')->nullable();
            $table->decimal('wallet_balance', 10, 2)->default(0.00);
            $table->integer('loyalty_points')->default(0);
            $table->boolean('is_verified')->default(false);
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};