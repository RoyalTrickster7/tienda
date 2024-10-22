<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Añadir un producto al carrito.
     */
    public function addToCart(Request $request, $productId)
    {
        // Buscar el producto en la base de datos
        $product = Product::find($productId);
    
        // Verificar si el producto existe
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Producto no encontrado');
        }
    
        // Obtener el carrito actual de la sesión
        $cart = Session::get('cart', []);
    
        // Verificar si el producto ya está en el carrito
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            // Añadir producto al carrito
            $cart[$productId] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1
            ];
        }
    
        // Guardar el carrito actualizado en la sesión
        Session::put('cart', $cart);
    
        return redirect()->route('cart.index')->with('success', 'Producto añadido al carrito');
    }
    
    /**
     * Mostrar el contenido del carrito.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    /**
     * Actualizar la cantidad de un producto en el carrito.
     */
    public function update(Request $request, $productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->input('quantity');
            Session::put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Cantidad actualizada');
        }

        return redirect()->route('cart.index')->with('error', 'Producto no encontrado en el carrito');
    }

    /**
     * Eliminar un producto del carrito.
     */
    public function remove(Request $request, $productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito');
        }

        return redirect()->route('cart.index')->with('error', 'Producto no encontrado en el carrito');
    }

    public function clearCart()
{
    Session::forget('cart');
    return redirect()->route('cart.index')->with('success', 'El carrito ha sido vaciado.');
}
}
