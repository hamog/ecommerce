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
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku');
            $table->decimal('price', 10);
            $table->decimal('discounted_price', 10)->default(0);
            $table->decimal('cost', 10)->default(0);
            $table->integer('quantity')->default(0);
            $table->boolean('track_quantity')->default(true);
            $table->boolean('sell_out_of_stock')->default(false);
            $table->text('description')->nullable();
            $table->string('status');
            $table->foreignId('category_id')->constrained()->nullOnDelete();
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
