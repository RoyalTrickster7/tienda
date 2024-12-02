@extends('layouts.app')

@section('title', 'Detalles del Pedido')

@section('content')
<h1>Detalles del Pedido #{{ $order->order_number }}</h1>
<p>Total: ${{ number_format($order->total_price, 2) }}</p>
<p>Estado: {{ ucfirst($order->order_status) }}</p>

<h3>Productos:</h3>
<ul class="list-group">
    @foreach ($order->orderItems as $item)
        <li class="list-group-item">
            {{ $item->product->name }} - 
            ${{ number_format($item->price, 2) }} x {{ $item->quantity }} 
            (Total: ${{ number_format($item->price * $item->quantity, 2) }})
        </li>
    @endforeach
</ul>

<a href="{{ route('orders.index') }}" class="btn btn-secondary mt-4">Volver al historial de pedidos</a>
@endsection
