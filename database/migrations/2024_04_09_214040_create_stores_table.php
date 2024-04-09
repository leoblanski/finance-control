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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable();
            $table->string('name');
            $table->string('cnpj')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('responsible_name')->nullable();
            $table->string('mobile')->nullable();
            $table->boolean('active');
            $table->timestamp('charge_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
