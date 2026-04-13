<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Produk</title>
@vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-100">

@if(session('success'))
<div class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-bounce">
    {{ session('success') }}
</div>
@endif

<div class="container mx-auto px-6 py-10">

<a href="{{ route('pelanggan.dashboard') }}"
class="text-pink-600 mb-6 inline-block">
← Kembali
</a>

<div class="bg-white rounded-2xl shadow p-6 grid md:grid-cols-2 gap-10">

    {{-- KIRI: GAMBAR --}}
    <div>
        <img src="{{ asset('storage/' . $produk->gambar) }}"
            class="rounded-xl w-full h-[350px] object-cover">

        {{-- Thumbnail (optional) --}}
        <div class="flex gap-3 mt-4">
            <div class="w-16 h-16 bg-white-0 rounded-lg"></div>
        </div>
    </div>

    {{-- KANAN: DETAIL --}}
    <div>

        {{-- Nama --}}
        <h1 class="text-2xl font-bold mb-2">
            {{ $produk->nama_produk }}
        </h1>

        {{-- Rating dummy --}}
        <div class="flex items-center gap-2 text-yellow-400 mb-2">
            ⭐⭐⭐⭐⭐
            <span class="text-gray-500 text-sm">(4.5)</span>
        </div>

        {{-- Harga --}}
        <div class="flex items-center gap-3 mb-3">
           <span class="text-2xl font-bold text-pink-600">
    Rp {{ number_format($produk->harga_diskon,0,',','.') }}
</span>

@if($produk->diskon > 0)
<span class="text-sm line-through text-gray-400">
    Rp {{ number_format($produk->harga,0,',','.') }}
</span>

<span class="bg-pink-100 text-pink-600 text-xs px-2 py-1 rounded">
    -{{ $produk->diskon }}%
</span>
@endif
        </div>

        {{-- Stok --}}
        <p class="text-sm text-gray-500 mb-4">
            Stok tersedia: <b>{{ $produk->stok }}</b>
        </p>

        <hr class="mb-4">

        {{-- DESKRIPSI --}}
        <h3 class="font-semibold mb-2">Deskripsi Produk</h3>
        <p class="text-gray-600 text-sm mb-4">
            {{ $produk->deskripsi ?? 'Tidak ada deskripsi' }}
        </p>

        {{-- INFO TAMBAHAN --}}
        <div class="grid grid-cols-2 gap-3 mb-4 text-sm">
            <div class="bg-gray-100 p-3 rounded-lg">
                Berat: 500g
            </div>
            <div class="bg-gray-100 p-3 rounded-lg">
                BPOM: NA18201234567
            </div>
            <div class="bg-gray-100 p-3 rounded-lg">
                Jenis: Semua
            </div>
            <div class="bg-gray-100 p-3 rounded-lg">
                Aman digunakan
            </div>
        </div>

        {{-- TAG --}}
        <div class="flex flex-wrap gap-2 mb-5">
            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs">Original</span>
            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs">Best Seller</span>
            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs">BPOM</span>
        </div>

        {{-- FORM --}}
        <form method="POST" action="{{ route('keranjang.tambah', $produk->id_produk) }}">
            @csrf

            {{-- JUMLAH --}}
            <div class="flex items-center gap-4 mb-5">

                <span>Jumlah:</span>

                <div class="flex border rounded-lg overflow-hidden">
                    <button type="button" onclick="minus()" class="px-3 bg-gray-200">-</button>

                    <input type="number" name="jumlah" id="qty"
                        value="1"
                        min="1"
                        max="{{ $produk->stok }}"
                        class="w-12 text-center outline-none">

                    <button type="button" onclick="plus()" class="px-3 bg-gray-200">+</button>
                </div>

                <span class="text-sm text-gray-400">
                    Maks: {{ $produk->stok }}
                </span>

            </div>

            {{-- BUTTON --}}
            <div class="flex gap-3">

                <button type="submit"
                    class="flex-1 bg-green-600 text-white py-3 rounded-xl hover:bg-green-700 transition">
                    🛒 Masukkan ke keranjang
                </button>

                <a href="{{ route('checkout') }}"
                    class="flex-1 text-center bg-orange-500 text-white py-3 rounded-xl hover:bg-orange-600 transition">
                    Beli sekarang
                </a>

            </div>

        </form>

    </div>

</div>

</div>

<script>
function plus() {
    let qty = document.getElementById('qty');
    qty.value = parseInt(qty.value) + 1;
}

function minus() {
    let qty = document.getElementById('qty');
    if(qty.value > 1) {
        qty.value = parseInt(qty.value) - 1;
    }
}
</script>

</body>
</html>