@extends('layouts.app')

@section('title', 'Pago Exitoso')

@section('content')
<div class="container text-center">
    <h1 class="mb-4 text-success">¡Gracias por tu compra!</h1>
    <p class="mb-4">Tu pago ha sido procesado exitosamente.</p>

    <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('products.index') }}" class="btn btn-primary">Volver al catálogo</a>
        <a href="{{ route('orders.index') }}" class="btn btn-success">Ver mis pedidos</a>
    </div>
</div>
@endsection
