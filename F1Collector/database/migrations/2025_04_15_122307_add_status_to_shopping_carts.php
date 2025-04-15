<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('f1collector_shopping_carts', function (Blueprint $table) {
            $table->string('status')->default('active')->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('f1collector_shopping_carts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};