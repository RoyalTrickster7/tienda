<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h1>Pagar</h1>
    
    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif

    <!-- Formulario de selección de método de pago -->
    <form action="{{ route('process.payment') }}" method="POST" id="payment-form">
        @csrf
        <input type="hidden" name="amount" value="1000"> <!-- Monto en dólares -->

        <div>
            <label for="payment_method">Selecciona un método de pago:</label>
            <select name="payment_method" id="payment_method">
                <option value="stripe">Tarjeta de Crédito (Stripe)</option>
                <option value="paypal">PayPal</option>
            </select>
        </div>

        <!-- Elemento de Stripe -->
        <div id="stripe-section">
            <div id="card-element">
                <!-- Stripe Elements se encarga de aquí -->
            </div>
        </div>

        <button type="submit">Proceder al Pago</button>
    </form>

    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        const paymentMethodSelect = document.getElementById('payment_method');
        const stripeSection = document.getElementById('stripe-section');

        // Mostrar u ocultar la sección de Stripe basado en el método de pago seleccionado
        paymentMethodSelect.addEventListener('change', function () {
            if (paymentMethodSelect.value === 'stripe') {
                stripeSection.style.display = 'block';
            } else {
                stripeSection.style.display = 'none';
            }
        });

        form.addEventListener('submit', async (event) => {
            if (paymentMethodSelect.value === 'stripe') {
                event.preventDefault();

                const { token, error } = await stripe.createToken(cardElement);
                if (error) {
                    console.error(error);
                } else {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', token.id);
                    form.appendChild(hiddenInput);
                    form.submit();
                }
            }
        });

        // Ocultar Stripe Elements al inicio si no está seleccionado
        if (paymentMethodSelect.value !== 'stripe') {
            stripeSection.style.display = 'none';
        }
    </script>
</body>
</html>
