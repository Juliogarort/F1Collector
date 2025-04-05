<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('f1collector_products', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED autoincremental
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->string('team');
            $table->integer('year');
            $table->unsignedBigInteger('category_id');
            $table->string('image');
            $table->text('description');
            $table->string('type');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('f1collector_categories');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('f1collector_products');
    }
};