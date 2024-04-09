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
        Schema::create('moviments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('store_id')->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('employee_id')->nullable();
            $table->unsignedBigInteger('status');
            $table->string('type');
            $table->foreignId('operation_type_id')->nullable();
            $table->decimal('amount');
            $table->decimal('discount');
            $table->string('obs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moviments');
    }
};
