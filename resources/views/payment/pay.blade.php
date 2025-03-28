@extends('layouts.app')

@section('content')
    <h1>Pembayaran untuk Order #{{ $order->id }}</h1>
    <button id="pay-button">Bayar Sekarang</button>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.getElementById('pay-button').onclick = function () {
            snap.pay('{{ $snapToken }}');
        };
    </script>
@endsection