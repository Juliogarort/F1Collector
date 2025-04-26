<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        // Verificar si la tabla ya existe antes de intentar crearla
        if (!Schema::hasTable('f1collector_wishlists')) {
            Schema::create('f1collector_wishlists', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('f1collector_users');
                $table->timestamps();
            });
        }
    }

    public function down() {
        Schema::dropIfExists('f1collector_wishlists');
    }
};