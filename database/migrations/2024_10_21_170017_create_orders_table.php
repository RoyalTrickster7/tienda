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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Identificador único del pedido
            $table->unsignedBigInteger('user_id'); // ID del usuario que realiza el pedido
            $table->string('order_number')->unique(); // Número de pedido único
            $table->decimal('total_price', 10, 2); // Precio total del pedido
            $table->string('payment_status')->default('pending'); // Estado del pago (pending, completed, failed)
            $table->string('order_status')->default('pending'); // Estado del pedido (pending, shipped, delivered, cancelled)
            $table->text('shipping_address'); // Dirección de envío
            $table->timestamps(); // Marca de tiempo de creación y actualización

            // Llave foránea para el usuario
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
