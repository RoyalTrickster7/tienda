<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Session;

class PaymentController extends Controller
{
    public function showCheckout()
    {
        return view('payment.checkout');
    }

    public function processPayment(Request $request)
    {
        // Configurar la clave secreta de Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Crear el cargo
            $charge = Charge::create([
                "amount" => $request->input('amount') * 100, // En centavos (ejemplo: $10.00 = 1000 centavos)
                "currency" => "usd",
                "source" => $request->input('stripeToken'),
                "description" => "Pago de ejemplo en tienda",
            ]);

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
