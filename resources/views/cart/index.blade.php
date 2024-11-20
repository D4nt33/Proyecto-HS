@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Shopping Cart</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('cart') && count(session('cart')) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach(session('cart') as $id => $details)
                    @php $total += $details['price'] * $details['quantity']; @endphp
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $details['image']) }}" style="width: 50px; height: 50px;">
                        </td>
                        <td>{{ $details['name'] }}</td>
                        <td>{{ $details['quantity'] }}</td>
                        <td>${{ number_format($details['price'], 2) }}</td>
                        <td>${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4 class="text-right">Total: ${{ number_format($total, 2) }}</h4>

        <form action="{{ route('cart.clear') }}" method="POST" class="text-center mt-4">
            @csrf
            <button type="submit" class="btn btn-danger">Clear Cart</button>
        </form>
    @else
        <p class="text-center">Your cart is empty!</p>
    @endif
</div>
<div id="paypal-button-container" class="d-flex justify-center mt-3"></div>
</div>

<div class="text-center mt-4">
    <div id="paypal-button-container"></div>
</div>
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency=USD"></script>

<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            // Obtén el total desde el carrito
            const total = {{ array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], session('cart', []))) }};

            // Configura los detalles del pago
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: total.toFixed(2), // Total en USD
                    },
                    description: "Purchase from Your Store"
                }]
            });
        },
        onApprove: function(data, actions) {
            // Finaliza la transacción en caso de éxito
            return actions.order.capture().then(function(details) {
                // Redirige o muestra un mensaje de éxito
                window.location.href = "{{ route('paypal.success') }}";
            });
        },
        onCancel: function(data) {
            // Maneja la cancelación
            alert('Payment cancelled');
        },
        onError: function(err) {
            // Maneja los errores
            console.error(err);
            alert('An error occurred during the payment process.');
        }
    }).render('#paypal-button-container'); // Renderiza el botón en el contenedor
</script>

@endsection
