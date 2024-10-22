<!DOCTYPE html>
<html>
<head>
    <title>Pago Exitoso</title>
</head>
<body>
    <h1>¡Gracias por tu compra!</h1>
    <p>Tu pago ha sido procesado exitosamente.</p>
    <a href="{{ route('products.index') }}">Volver al catálogo</a>
   

     <!-- Botón para ir al historial de pedidos -->
     <a href="{{ route('orders.index') }}" class="btn-view-orders">Ver mis pedidos</a>

     <style>
        .btn-view-orders {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-view-orders:hover {
            background-color: #218838;
        }
    </style>
</body>
</html>
