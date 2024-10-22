<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

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
        $order = Order::with('orderItems.product')->where('id', $orderId)->where('user_id', auth()->id())->firstOrFail();
        return view('orders.show', compact('order'));
    }
}
