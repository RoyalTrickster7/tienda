<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;


class PaymentController extends Controller
{
    public function showCheckout()
    {
        return view('payment.checkout');
    }

    public function processPayment(Request $request)
    {
         // Verificar si el usuario está autenticado
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Debes iniciar sesión para proceder con el pago.');
    }
        // Configurar la clave secreta de Stripe
        Stripe::setApiKey(config('services.stripe.secret'));
    
        try {
            // Crear el cargo en Stripe
            $charge = Charge::create([
                "amount" => $request->input('amount') * 100, // En centavos (ejemplo: $10.00 = 1000 centavos)
                "currency" => "usd",
                "source" => $request->input('stripeToken'),
                "description" => "Pago de ejemplo en tienda",
            ]);
    
            // Crear un pedido en la base de datos
            $order = Order::create([
                'user_id' => auth()->id(), // ID del usuario autenticado
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'total_price' => $request->input('amount'),
                'payment_status' => 'completed',
                'order_status' => 'pending',
                'shipping_address' => '123 Calle Ejemplo, Ciudad', // Esto puede obtenerse del formulario de pago si lo implementas
            ]);
    
            // Obtener los productos del carrito y guardarlos en order_items
            $cart = Session::get('cart', []);
            foreach ($cart as $productId => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }
    
            // Vaciar el carrito
            Session::forget('cart');
    
            // Redirigir con mensaje de éxito
            return redirect()->route('payment.success')->with('success', 'Pago realizado con éxito');
        } catch (\Exception $e) {
            // Redirigir con mensaje de error
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function paymentSuccess()
    {
        return view('payment.success');
    }
}
