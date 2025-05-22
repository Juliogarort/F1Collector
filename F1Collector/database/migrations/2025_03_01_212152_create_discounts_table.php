<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        // Crear tabla de descuentos
        Schema::create('f1collector_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['simple', 'category', 'product']);
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('used')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            // Opcional: definir claves foráneas si quieres relaciones directas
            // $table->foreign('category_id')->references('id')->on('f1collector_categories')->nullOnDelete();
            // $table->foreign('product_id')->references('id')->on('f1collector_products')->nullOnDelete();
        });

        // Añadir campos de descuento a la tabla de órdenes
        Schema::table('f1collector_orders', function (Blueprint $table) {
            // Verificar si las columnas no existen antes de añadirlas
            if (!Schema::hasColumn('f1collector_orders', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->nullable()->after('total');
            }
            if (!Schema::hasColumn('f1collector_orders', 'discount_amount')) {
                $table->decimal('discount_amount', 10, 2)->default(0)->after('subtotal');
            }
            if (!Schema::hasColumn('f1collector_orders', 'discount_code')) {
                $table->string('discount_code')->nullable()->after('discount_amount');
            }
        });
    }

    public function down() {
        // Eliminar tabla de descuentos
        Schema::dropIfExists('f1collector_discounts');
        
        // Eliminar campos de descuento de la tabla de órdenes
        Schema::table('f1collector_orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'discount_amount', 'discount_code']);
        });
    }
};