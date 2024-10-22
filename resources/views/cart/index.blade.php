<!DOCTYPE html>
<html>
<head>
    <title>Carrito de Compras</title>
</head>
<body>
    <h1>Carrito de Compras</h1>

    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif

    @if (!empty($cart))
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $id => $details)
                    <tr>
                        <td>{{ $details['name'] }}</td>
                        <td>${{ $details['price'] }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.update', $id) }}">
                                @csrf
                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1">
                                <button type="submit">Actualizar</button>
                            </form>
                        </td>
                        <td>${{ $details['price'] * $details['quantity'] }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.remove', $id) }}">
                                @csrf
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
       <!-- Botón para proceder al pago -->
<a href="{{ route('checkout') }}" class="btn-proceed-to-checkout">Proceder al Pago</a>
    @else
        <p>Tu carrito está vacío</p>
    @endif

    <a href="{{ route('cart.clear') }}">Vaciar carrito</a>
    <a href="{{ route('products.index') }}">Volver al catálogo</a>

   
</body>
</html>
