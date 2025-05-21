<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('f1collector_valoraciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('f1collector_users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('f1collector_products')->onDelete('cascade');
            $table->foreignId('order_id')->constrained('f1collector_orders')->onDelete('cascade');
            $table->integer('puntuacion')->unsigned()->comment('Puntuación de 1 a 5 estrellas');
            $table->text('comentario')->nullable();
            $table->boolean('compra_verificada')->default(true);
            $table->boolean('aprobada')->default(true);
            $table->timestamps();
            // Evita que un usuario valore el mismo producto más de una vez
            $table->unique(['user_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('f1collector_valoraciones');
    }
};