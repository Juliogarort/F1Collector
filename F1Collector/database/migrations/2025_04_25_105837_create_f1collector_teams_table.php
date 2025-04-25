<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('f1collector_teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Ej: "Ferrari", "Red Bull"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('f1collector_teams');
    }
};
