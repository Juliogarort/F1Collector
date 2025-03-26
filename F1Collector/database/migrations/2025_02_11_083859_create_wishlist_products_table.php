<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('f1collector_wishlist_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wishlist_id')->constrained('f1collector_wishlists');
            $table->foreignId('product_id')->constrained('f1collector_products');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('f1collector_wishlist_products');
    }
};
