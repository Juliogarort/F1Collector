<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('f1collector_wishlist_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wishlist_id');
            $table->unsignedBigInteger('product_id'); // Debe coincidir con products.id
            $table->timestamps();

            $table->foreign('wishlist_id')->references('id')->on('f1collector_wishlists');
            $table->foreign('product_id')->references('id')->on('f1collector_products');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('f1collector_wishlist_products');
    }
};