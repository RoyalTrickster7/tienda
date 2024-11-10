<!DOCTYPE html>
<html>
<head>
    <title>Detalles del Pedido</title>
</head>
<body>
    <h1>Detalles del Pedido #{{ $order->order_number }}</h1>
    
    <p>Total: ${{ number_format($order->total_price, 2) }}</p>
    <p>Estado: {{ $order->order_status }}</p>

    <h3>Productos:</h3>
    <ul>
        @foreach ($order->orderItem as $item)
            <li>
                {{ $item->product->name }} - 
                ${{ number_format($item->price, 2) }} x {{ $item->quantity }} 
                (Total: ${{ number_format($item->price * $item->quantity, 2) }})
            </li>
        @endforeach
    </ul>

    <a href="{{ route('orders.index') }}">Volver al historial de pedidos</a>
</body>
</html>
