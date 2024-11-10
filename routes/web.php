<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;


//Main
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Catalogo
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

require __DIR__.'/auth.php';

//Todo lo del carrito
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

// Procesador de pago y gestión de pedidos: requiere que el usuario esté autenticado
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [PaymentController::class, 'showCheckout'])->name('checkout');
    Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('process.payment');
    Route::get('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

    //Paypal
    Route::get('/paypal-success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('/paypal-cancel', [PaymentController::class, 'showCheckout'])->name('paypal.cancel');
    


    // Gestión de pedidos
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});
