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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Identificador único del producto
            $table->string('name'); // Nombre del producto
            $table->text('description')->nullable(); // Descripción del producto
            $table->decimal('price', 10, 2); // Precio del producto
            $table->integer('stock')->default(0); // Cantidad en stock
            $table->unsignedBigInteger('category_id'); // ID de la categoría (relación con una tabla de categorías)
            $table->decimal('rating', 2, 1)->nullable(); // Calificación del producto (1.0 a 5.0)
            $table->timestamps(); // Marca de tiempo de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
