<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('f1collector_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code', 20);
            $table->string('country');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('f1collector_addresses');
    }
};
