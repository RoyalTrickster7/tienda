<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   /**
     * Mostrar el catálogo de productos.
     */
    public function index(Request $request)
    {
        // Obtener los filtros de la solicitud (si existen)
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $rating = $request->input('rating');

        // Query básica para obtener productos
        $products = Product::query();

        // Aplicar filtros si existen
        if ($category) {
            $products->where('category_id', $category);
        }

        if ($minPrice && $maxPrice) {
            $products->whereBetween('price', [$minPrice, $maxPrice]);
        }

        if ($rating) {
            $products->where('rating', '>=', (int) $rating);
        }

        // Paginar los resultados
        $products = $products->paginate(12);

        // Retornar la vista con los productos filtrados
        return view('products.index', compact('products'));
    }
}
