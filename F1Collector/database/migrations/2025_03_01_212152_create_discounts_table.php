<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('f1collector_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['simple', 'category', 'product']);
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('used')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            // Opcional: definir claves foráneas si quieres relaciones directas
            // $table->foreign('category_id')->references('id')->on('f1collector_categories')->nullOnDelete();
            // $table->foreign('product_id')->references('id')->on('f1collector_products')->nullOnDelete();
        });
    }

    public function down() {
        Schema::dropIfExists('f1collector_discounts');
    }
};
