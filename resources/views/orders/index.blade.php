@extends('layouts.app')

@section('title', 'Historial de Pedidos')

@section('content')
<div class="container">
    <h1 class="mb-4">Historial de Pedidos</h1>

    @if ($orders->isEmpty())
        <div class="alert alert-info">No has realizado ningún pedido.</div>
    @else
        <ul class="list-group">
            @foreach ($orders as $order)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('orders.show', $order->id) }}">Pedido #{{ $order->order_number }}</a>
                    <span>${{ number_format($order->total_price, 2) }}</span>
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('products.index') }}" class="btn btn-primary mt-4">Volver al catálogo</a>
</div>
@endsection
