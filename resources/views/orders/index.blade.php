<!DOCTYPE html>
<html>
<head>
    <title>Historial de Pedidos</title>
</head>
<body>
    <h1>Historial de Pedidos</h1>

    @if ($orders->isEmpty())
        <p>No has realizado ningún pedido.</p>
    @else
        <ul>
            @foreach ($orders as $order)
                <li>
                    <a href="{{ route('orders.show', $order->id) }}">Pedido #{{ $order->order_number }}</a> - ${{ $order->total_price }}
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('products.index') }}">Volver al catálogo</a>
</body>
</html>
