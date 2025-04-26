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
        if (!Schema::hasTable('f1collector_order_items')) {
            Schema::create('f1collector_order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('f1collector_orders')->onDelete('cascade');
                $table->foreignId('product_id')->constrained('f1collector_products')->onDelete('cascade');
                $table->integer('quantity');
                $table->decimal('price', 8, 2);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('f1collector_order_items');
    }
};