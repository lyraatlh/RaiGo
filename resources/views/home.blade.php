@extends('layouts.app')
@section('content')
<h1>Selamat Datang di RaiGo!</h1>
<p class="text-center">Platform digital untuk UMKM.</p>

<h2 class="mt-4">Produk UMKM</h2>
<div class="row">
    @foreach ($products as $product)
        <div class="col-md-4">
            <div class="card">
                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <a href="{{ route('checkout', $product->id) }}" class="btn btn-success">Beli</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
<a href="{{ route('login') }}">Login</a>
@endsection