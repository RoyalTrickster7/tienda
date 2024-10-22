<!DOCTYPE html>
<html>
<head>
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Catálogo de Productos</h1>

        <!-- Formulario de filtros -->
        <form method="GET" action="{{ route('products.index') }}">
            <div>
                <label for="category">Categoría:</label>
                <select name="category" id="category">
                    <option value="">Todas</option>
                    <option value="1">Categoría 1</option>
                    <option value="2">Categoría 2</option>
                    <option value="3">Categoría 3</option>
                    <option value="4">Categoría 4</option>
                    <option value="5">Categoría 5</option>
                </select>
            </div>
            <div>
                <label for="min_price">Precio mínimo:</label>
                <input type="number" name="min_price" id="min_price" step="0.01">
            </div>
            <div>
                <label for="max_price">Precio máximo:</label>
                <input type="number" name="max_price" id="max_price" step="0.01">
            </div>
            <div>
                <label for="rating">Calificación mínima:</label>
                <select name="rating" id="rating">
                    <option value="">Todas</option>
                    <option value="1">1 estrella</option>
                    <option value="2">2 estrellas</option>
                    <option value="3">3 estrellas</option>
                    <option value="4">4 estrellas</option>
                    <option value="5">5 estrellas</option>
                </select>
            </div>
            <button type="submit">Aplicar Filtros</button>
        </form>

        <!-- Lista de productos -->
        <div class="products">
            @foreach($products as $product)
                <div class="product">
                    <h2>{{ $product->name }}</h2>
                    <p>{{ $product->description }}</p>
                    <p>Precio: ${{ $product->price }}</p>
                    <p>Calificación: {{ $product->rating }} estrellas</p>

                    <!-- Botón para añadir al carrito -->
                    <form method="POST" action="{{ route('cart.add', $product->id) }}">
                        @csrf
                        <button type="submit">Añadir al carrito</button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div>
            {{ $products->links() }}
        </div>
    </div>
</body>
</html>
