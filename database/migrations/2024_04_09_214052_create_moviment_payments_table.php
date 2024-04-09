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
        Schema::create('moviment_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable();
            $table->foreignId('payment_type_id')->nullable();
            $table->foreignId('moviment_id')->nullable();
            $table->decimal('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moviment_payments');
    }
};
