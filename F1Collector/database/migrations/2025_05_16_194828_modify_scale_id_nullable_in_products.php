<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('f1collector_products', function (Blueprint $table) {
            // Eliminar foreign key anterior
            $table->dropForeign(['scale_id']);

            // Permitir NULL
            $table->unsignedBigInteger('scale_id')->nullable()->change();

            // Crear nueva FK con ON DELETE SET NULL
            $table->foreign('scale_id')
                ->references('id')
                ->on('f1collector_scales')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('f1collector_products', function (Blueprint $table) {
            $table->dropForeign(['scale_id']);
            $table->unsignedBigInteger('scale_id')->nullable(false)->change();
            $table->foreign('scale_id')
                ->references('id')
                ->on('f1collector_scales')
                ->onDelete('restrict');
        });
    }
};
 
