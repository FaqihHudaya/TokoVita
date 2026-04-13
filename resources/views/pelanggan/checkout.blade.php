<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Checkout
        </h2>
    </x-slot>

    <div class="p-8 bg-gray-100 min-h-screen">

        @if(count($keranjang) > 0)

        <div class="grid md:grid-cols-3 gap-6">

            {{-- FORM --}}
            <div class="md:col-span-2 bg-white p-6 rounded-xl shadow">

                <form action="{{ route('checkout.proses') }}" method="POST">
                    @csrf

                    <div class="mb-4">
    <label class="block font-semibold mb-1">Nama Lengkap</label>
    <div class="bg-gray-100 p-3 rounded-lg">
        {{ Auth::user()->nama }}
    </div>
</div>

                    <div class="mb-4">
    <label class="block font-semibold mb-1">No HP</label>
    <div class="bg-gray-100 p-3 rounded-lg">
        {{ Auth::user()->no_telfon }}
    </div>
</div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Alamat</label>
                        <textarea name="alamat"
                            class="w-full border rounded-lg p-2" required></textarea>
                    </div>

                    <div class="mb-4">
    <label class="block mb-1 font-medium">Catatan</label>
    <textarea name="catatan"
        class="w-full border rounded-lg p-2"
        placeholder="Contoh: Tolong diapakan dulu "></textarea>
</div>

<div class="mb-4">
    <label class="block mb-2 font-semibold">Metode Penerimaan</label>

    <div class="flex gap-6">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="radio" name="metode_penerimaan" value="Ambil di Toko" required>
            <span>Ambil di Toko</span>
        </label>
    </div>
</div>

                    <button class="bg-pink-600 text-white px-6 py-3 rounded-xl hover:bg-pink-700">
                        Buat Pesanan
                    </button>

                </form>

            </div>

            {{-- RINGKASAN --}}
            <div class="bg-white p-6 rounded-xl shadow h-fit">

                <h3 class="font-semibold mb-4">Ringkasan Pesanan</h3>

                @php $total = 0; @endphp

                @foreach($keranjang as $item)
                    @php 
                         $harga = $item->produk->harga_diskon;
                         $subtotal = $harga * $item->jumlah;
                         $total += $subtotal;
                    @endphp

                    <div class="flex justify-between text-sm mb-2">
                        <span>{{ $item->produk->nama_produk }}</span>
                        <span>Rp {{ number_format($subtotal,0,',','.') }}</span>
                    </div>
                @endforeach

                <hr class="my-3">

                <div class="flex justify-between font-bold">
                    <span>Total</span>
                    <span class="text-pink-600">
                        Rp {{ number_format($total,0,',','.') }}
                    </span>
                </div>

            </div>

        </div>

        @else

            <div class="bg-white p-6 rounded shadow text-center">
                Keranjang kosong.
            </div>

        @endif

    </div>

</body>
</html>