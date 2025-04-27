<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Crear tabla de equipos
        Schema::create('f1collector_teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Ej: "Ferrari", "Red Bull"
            $table->timestamps();
        });

        // 2. Crear tabla de escalas
        Schema::create('f1collector_scales', function (Blueprint $table) {
            $table->id();
            $table->string('value')->unique(); // Ej: "1:18", "1:43"
            $table->timestamps();
        });

        // 3. Crear tabla de productos (ahora con relaciones)
        Schema::create('f1collector_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->unsignedBigInteger('team_id'); // Relación con teams
            $table->integer('year');
            $table->unsignedBigInteger('category_id');
            $table->string('image');
            $table->text('description');
            $table->unsignedBigInteger('scale_id'); // Relación con scales
            $table->timestamps();

            // Definir las relaciones
            $table->foreign('category_id')->references('id')->on('f1collector_categories');
            $table->foreign('team_id')->references('id')->on('f1collector_teams');
            $table->foreign('scale_id')->references('id')->on('f1collector_scales');
        });
    }

    public function down(): void
    {
        // Eliminar las tablas en orden inverso para evitar errores de restricción
        Schema::dropIfExists('f1collector_products');
        Schema::dropIfExists('f1collector_scales');
        Schema::dropIfExists('f1collector_teams');
    }
};