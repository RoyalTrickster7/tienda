<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Contracts\Database\Eloquent\Builder;

class OrderController extends Controller
{
     /**
     * Mostrar el historial de pedidos del usuario.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Mostrar los detalles de un pedido específico.
     */
    public function show($orderId)
    {
        $order = Order::with(['orderItem' => function(builder $query) {
            $query->with('product');

        }])->where('id', $orderId)->firstOrFail();
        
       // $orderitems = OrderItem::where('order_id', $orderId)->get();

       // dump($order);

     //dd($order);
        
        return view('orders.show', compact('order'));
    }
}
