<!DOCTYPE html>
<html>
<head>
    <title>Detalles del Pedido</title>
</head>
<body>
    <h1>Detalles del Pedido #{{ $order->order_number }}</h1>

    <p>Total: ${{ $order->total_price }}</p>
    <p>Estado: {{ $order->order_status }}</p>

    <h2>Productos:</h2>
    <ul>
        @foreach ($order->orderItems as $item)
            <li>{{ $item->quantity }} x {{ $item->product->name }} - ${{ $item->price }}</li>
        @endforeach
    </ul>

    <a href="{{ route('orders.index') }}">Volver al historial de pedidos</a>
</body>
</html>
