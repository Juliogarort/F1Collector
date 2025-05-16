<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('f1collector_products', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->unsignedBigInteger('team_id')->nullable()->change();
            $table->foreign('team_id')
                  ->references('id')
                  ->on('f1collector_teams')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('f1collector_products', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->unsignedBigInteger('team_id')->nullable(false)->change();
            $table->foreign('team_id')
                  ->references('id')
                  ->on('f1collector_teams')
                  ->onDelete('restrict');
        });
    }
};

