@extends('layouts.app')

@section('title', 'Catálogo de Productos')

@section('content')
<div class="container">
    <h1 class="mb-4">Catálogo de Productos</h1>

    <!-- Formulario de filtros -->
    <form method="GET" action="{{ route('products.index') }}" class="mb-4 row">
        <div class="col-md-3">
            <label for="category" class="form-label">Categoría:</label>
            <select name="category" id="category" class="form-select">
                <option value="">Todas</option>
                <option value="1">Categoría 1</option>
                <option value="2">Categoría 2</option>
                <option value="3">Categoría 3</option>
                <option value="4">Categoría 4</option>
                <option value="5">Categoría 5</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="min_price" class="form-label">Precio mínimo:</label>
            <input type="number" name="min_price" id="min_price" class="form-control" step="0.01">
        </div>
        <div class="col-md-3">
            <label for="max_price" class="form-label">Precio máximo:</label>
            <input type="number" name="max_price" id="max_price" class="form-control" step="0.01">
        </div>
        <div class="col-md-3">
            <label for="rating" class="form-label">Calificación mínima:</label>
            <select name="rating" id="rating" class="form-select">
                <option value="">Todas</option>
                <option value="1">1 estrella</option>
                <option value="2">2 estrellas</option>
                <option value="3">3 estrellas</option>
                <option value="4">4 estrellas</option>
                <option value="5">5 estrellas</option>
            </select>
        </div>
        <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
        </div>
    </form>

    <!-- Lista de productos -->
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">${{ number_format($product->price, 2) }}</p>
                        <p class="card-text">Calificación: {{ $product->rating }} estrellas</p>
                        <form method="POST" action="{{ route('cart.add', $product->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Añadir al carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Paginación -->
    {{ $products->links() }}
</div>
@endsection
