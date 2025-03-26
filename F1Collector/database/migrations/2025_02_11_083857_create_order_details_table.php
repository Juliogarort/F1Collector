<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('f1collector_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('f1collector_orders');
            $table->foreignId('product_id')->constrained('f1collector_products');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('f1collector_order_details');
    }
};
