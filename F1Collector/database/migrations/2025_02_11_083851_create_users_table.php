<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('f1collector_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Añade estos dos campos
            $table->string('google_id')->nullable();
            $table->string('avatar')->nullable();

            $table->rememberToken();
            $table->foreignId('address_id')->nullable()->constrained('f1collector_addresses')->nullOnDelete();
            $table->string('phone', 20)->unique()->nullable();
            $table->enum('user_type', ['Admin', 'Customer'])->default('Customer');
            $table->timestamps();
        });

        Schema::create('f1collector_password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('f1collector_sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index()->constrained('f1collector_users')->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('f1collector_users');
        Schema::dropIfExists('f1collector_password_reset_tokens');
        Schema::dropIfExists('f1collector_sessions');
    }
};
