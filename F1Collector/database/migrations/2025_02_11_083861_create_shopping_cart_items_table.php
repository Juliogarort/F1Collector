<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('f1collector_shopping_cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shopping_cart_id'); // Debe coincidir con shopping_carts.id
            $table->unsignedBigInteger('product_id'); // Debe coincidir con products.id
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('shopping_cart_id')->references('id')->on('f1collector_shopping_carts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('f1collector_products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('f1collector_shopping_cart_items');
    }
};