@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<h1>Checkout</h1>
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ route('process.payment') }}" method="POST" id="payment-form">
    @csrf
    <input type="hidden" name="amount" value="1000"> <!-- Monto en dólares -->

    <div class="form-group">
        <label for="payment_method">Selecciona un método de pago:</label>
        <select name="payment_method" id="payment_method" class="form-select">
            <option value="stripe">Tarjeta de Crédito (Stripe)</option>
            <option value="paypal">PayPal</option>
        </select>
    </div>

    <div id="stripe-section" class="mt-3">
        <div id="card-element"></div>
    </div>

    <button type="submit" class="btn btn-success mt-3">Proceder al Pago</button>
</form>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const paymentMethodSelect = document.getElementById('payment_method');
    const stripeSection = document.getElementById('stripe-section');

    paymentMethodSelect.addEventListener('change', () => {
        stripeSection.style.display = paymentMethodSelect.value === 'stripe' ? 'block' : 'none';
    });

    stripeSection.style.display = paymentMethodSelect.value === 'stripe' ? 'block' : 'none';
</script>
@endsection
