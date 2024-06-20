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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('reference')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('product_brand_id')->nullable();
            $table->foreignId('product_line_id')->nullable();
            $table->foreignId('product_category_id')->nullable();
            $table->json('photos')->nullable();
            $table->string('codebar')->nullable();
            $table->boolean('active');
            $table->decimal('cost_price');
            $table->decimal('sale_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
