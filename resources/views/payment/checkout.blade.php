<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h1>Pagar con Stripe</h1>
    
    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif

    <form action="{{ route('process.payment') }}" method="POST" id="payment-form">
        @csrf
        <input type="hidden" name="amount" value="1000"> <!-- Monto en dólares ($10.00) -->

        <div id="card-element">
            <!-- Stripe Elements se encarga de aquí -->
        </div>

        <button type="submit" id="submit-button">Pagar</button>
    </form>

    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (event) => {
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
        });
    </script>
</body>
</html>
