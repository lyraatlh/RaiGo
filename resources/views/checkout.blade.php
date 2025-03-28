@extends('layouts.app')

@section('content')
    <h1>Checkout</h1>
    <p>Produk: {{ $product->name }}</p>
    <p>Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
    
    <label for="province">Pilih Provinsi:</label>
    <select id="province" name="province">
        @foreach(App\Services\RajaOngkirService::getProvinces() as $province)
            <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
        @endforeach
    </select>

    <label for="city">Pilih Kota:</label>
    <select id="city" name="city"></select>

    <label for="courier">Kurir:</label>
    <select id="courier">
        <option value="jne">JNE</option>
        <option value="pos">POS Indonesia</option>
        <option value="tiki">TIKI</option>
    </select>

    <button id="calculate-shipping">Hitung Ongkir</button>
    <p>Ongkir: <span id="shipping-cost">-</span></p>

    <script>
        document.getElementById('province').onchange = function() {
            fetch('/cities?province_id=' + this.value)
                .then(response => response.json())
                .then(data => {
                    let citySelect = document.getElementById('city');
                    citySelect.innerHTML = '';
                    data.forEach(city => {
                        citySelect.innerHTML += `<option value="${city.city_id}">${city.city_name}</option>`;
                    });
                });
        };

        document.getElementById('calculate-shipping').onclick = function() {
            let origin = 501; // Kota asal (contoh: Yogyakarta)
            let destination = document.getElementById('city').value;
            let weight = 1000; // Berat dalam gram
            let courier = document.getElementById('courier').value;

            fetch('/shipping-cost', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ origin, destination, weight, courier })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('shipping-cost').innerText = data[0].costs[0].cost[0].value;
            });
        };
    </script>
@endsection