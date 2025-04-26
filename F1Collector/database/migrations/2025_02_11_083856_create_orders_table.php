<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('f1collector_orders')) {
            Schema::create('f1collector_orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('f1collector_users')->onDelete('cascade');
                $table->decimal('total', 10, 2);
                $table->string('shipping_address')->nullable();
                $table->string('shipping_city')->nullable();
                $table->string('shipping_province')->nullable();
                $table->string('shipping_zip', 10)->nullable();
                $table->string('shipping_phone', 20)->nullable();
                $table->string('full_name')->nullable();
                $table->string('payment_method')->default('stripe');
                $table->string('status')->default('pending');
                $table->string('payment_id')->nullable();
                $table->timestamp('payment_date')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('f1collector_orders');
    }
};