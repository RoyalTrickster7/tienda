<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use GuzzleHttp\Client;

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

        // Determinar el método de pago seleccionado
        $paymentMethod = $request->input('payment_method');

        if ($paymentMethod === 'stripe') {
            return $this->processStripePayment($request);
        } elseif ($paymentMethod === 'paypal') {
            return $this->processPayPalPayment($request);
        }

        return redirect()->back()->with('error', 'Método de pago no válido.');
    }

    public function processStripePayment($request)
    {
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

            // Crear el pedido en la base de datos
            return $this->createOrder($request->input('amount'), 'stripe');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function processPayPalPayment(Request $request)
    {
        // Crear una instancia de cliente Guzzle para la API de PayPal
        $client = new Client();

        try {
            // Configurar la autenticación con PayPal y obtener un token de acceso
            $response = $client->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
                'auth' => [config('services.paypal.client_id'), config('services.paypal.secret')],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]);

            $accessToken = json_decode($response->getBody())->access_token;

            // Crear un pago en PayPal
            $response = $client->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [
                        [
                            'amount' => [
                                'currency_code' => 'USD',
                                'value' => $request->input('amount'),
                            ],
                        ],
                    ],
                    'application_context' => [
                        'return_url' => route('paypal.success'),
                        'cancel_url' => route('paypal.cancel'),
                    ],
                ],
            ]);

            // Obtener el link de aprobación de PayPal para redirigir al usuario
            $order = json_decode($response->getBody());
            $approvalLink = collect($order->links)->firstWhere('rel', 'approve')->href;

            return redirect($approvalLink);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function paypalSuccess(Request $request)
    {
        $client = new Client();
    
        try {
            // Obtener el token de acceso para completar el pago
            $response = $client->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
                'auth' => [config('services.paypal.client_id'), config('services.paypal.secret')],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]);
    
            $accessToken = json_decode($response->getBody())->access_token;
    
            // Capturar el pedido con PayPal
            $orderID = $request->query('token');
            $response = $client->post("https://api-m.sandbox.paypal.com/v2/checkout/orders/{$orderID}/capture", [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => 'application/json',
                ],
            ]);
    
            $orderData = json_decode($response->getBody(), true);
    
            // Verificar si la respuesta contiene los datos esperados
            if (isset($orderData['purchase_units'][0]['payments']['captures'][0]['amount']['value'])) {
                $totalAmount = $orderData['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
    
                // Crear el pedido en la base de datos
                $this->createOrder($totalAmount, 'paypal');
    
                // Redirigir a la página de éxito después de capturar el pedido
                return redirect()->route('payment.success')->with('success', 'Pago realizado con éxito');
            } else {
                // Manejar el caso donde la estructura no es la esperada
                return redirect()->route('checkout')->with('error', 'No se pudo obtener el monto del pago de PayPal.');
            }
            
        } catch (\Exception $e) {
            return redirect()->route('checkout')->with('error', $e->getMessage());
        }
    }

    public function paymentSuccess()
    {
        return view('payment.success');
    }

    private function createOrder($amount, $paymentMethod)
    {
        // Crear el pedido en la base de datos
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'total_price' => $amount,
            'payment_status' => 'completed',
            'order_status' => 'pending',
            'shipping_address' => '123 Calle Ejemplo, Ciudad',
        ]);

        // Obtener productos del carrito y crear registros en OrderItem
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
    }
}
