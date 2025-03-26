<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('f1collector_products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->decimal('price', 10, 2);
            $table->string('liga', 100);
            $table->foreignId('category_id')->nullable()->constrained('f1collector_categories')->onDelete('set null');
            $table->string('image')->nullable(); // Añadir columna para imagen
            $table->string('description', 1000)->nullable();
            $table->string('type', 100);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('f1collector_products');
    }
};
