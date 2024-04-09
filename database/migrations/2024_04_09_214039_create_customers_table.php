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
            $table->foreignId('brand_id')->nullable();
            $table->string('name');
            $table->string('cpf')->nullable();
            $table->timestamp('birthday')->nullable();
            $table->string('mobile')->nullable();
            $table->string('cep')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('neighborhood')->nullable();
            $table->boolean('active');
            $table->string('complement')->nullable();
            $table->foreignId('user_id')->nullable();
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
