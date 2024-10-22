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
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // Identificador único del carrito
            $table->unsignedBigInteger('user_id')->nullable(); // ID del usuario que posee el carrito, nullable para carritos de usuarios no registrados
            $table->unsignedBigInteger('product_id'); // ID del producto en el carrito
            $table->integer('quantity'); // Cantidad de ese producto en el carrito
            $table->timestamps(); // Marca de tiempo de creación y actualización

            // Llaves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
