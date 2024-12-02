@extends('layouts.app')

@section('title', 'Carrito de Compras')

@section('content')
<div class="container">
    <h1 class="mb-4">Carrito de Compras</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (!empty($cart))
        <table class="table table-striped">
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
                        <td>${{ number_format($details['price'], 2) }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.update', $id) }}" class="d-flex">
                                @csrf
                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="form-control w-25">
                                <button type="submit" class="btn btn-sm btn-primary ms-2">Actualizar</button>
                            </form>
                        </td>
                        <td>${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.remove', $id) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('cart.clear') }}" class="btn btn-warning">Vaciar carrito</a>
            <a href="{{ route('checkout') }}" class="btn btn-success">Proceder al Pago</a>
        </div>
    @else
        <div class="alert alert-info">Tu carrito está vacío</div>
    @endif

    <a href="{{ route('products.index') }}" class="btn btn-primary mt-4">Volver al catálogo</a>
</div>
@endsection
