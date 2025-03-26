<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('f1collector_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('f1collector_users');
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('f1collector_orders');
    }
};
