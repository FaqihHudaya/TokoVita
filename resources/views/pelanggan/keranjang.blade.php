<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>

<div class="bg-gray-100 min-h-screen p-8">

<a href="{{ route('pelanggan.dashboard') }}"
class="text-pink-600 mb-6 inline-block">
← Kembali
</a>

    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        🛒 Keranjang Belanja
    </h2>


    {{-- Cek apakah ada barang di keranjang --}}
    @if(count($keranjang) > 0)

        <div class="grid md:grid-cols-10 gap-8">

            {{-- LIST PRODUK --}}
            <div class="md:col-span-8 space-y-10">

                @php $total = 0; $jumlahItem = 0; @endphp

                @foreach($keranjang as $item)
                @php 
                    $harga = $item->produk->harga_diskon ?? $item->produk->harga;
                    $subtotal = $harga * $item->jumlah;
                    $total += $subtotal;
                    $jumlahItem += $item->jumlah;
                @endphp

                <div class="bg-white p-5 rounded-xl shadow flex gap-8 items-center">

                    <img src="{{ asset('storage/'.$item->produk->gambar) }}"
                         class="w-24 h-24 object-cover rounded-lg">

                    <div class="flex-1">
                        <h3 class="font-semibold text-lg">
                            {{ $item->produk->nama_produk }}
                        </h3>

                        @if($item->produk->diskon > 0)
                            <p class="text-pink-600 font-bold text-sm">
                                Rp {{ number_format($item->produk->harga_diskon,0,',','.') }}
                            </p>
                            <p class="text-gray-400 line-through text-xs">
                                Rp {{ number_format($item->produk->harga,0,',','.') }}
                            </p>
                            <span class="text-xs bg-pink-100 text-pink-600 px-2 py-1 rounded">
                                -{{ $item->produk->diskon }}%
                            </span>
                        @else
                            <p class="text-pink-600 font-bold text-sm">
                                Rp {{ number_format($item->produk->harga,0,',','.') }}
                            </p>
                        @endif

                        <div class="mt-3 flex items-center gap-4">

                            {{-- TOMBOL - + --}}
                            <form action="{{ route('keranjang.update',$item->id_keranjang) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="flex items-center border rounded-lg overflow-hidden">
                                    <button type="submit" name="jumlah" value="{{ $item->jumlah - 1 }}" class="px-3 py-1 bg-gray-200 hover:bg-gray-300">
                                        -
                                    </button>
                                    <span class="px-4">
                                        {{ $item->jumlah }}
                                    </span>
                                    <button type="submit" name="jumlah" value="{{ $item->jumlah + 1 }}" class="px-3 py-1 bg-gray-200 hover:bg-gray-300">
                                        +
                                    </button>
                                </div>
                            </form>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('keranjang.hapus',$item->id_keranjang) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-sm">
                                    🗑 Hapus
                                </button>
                            </form>

                        </div>

                    </div>

                    <div class="text-right">
                        <p class="text-pink-600 font-bold text-lg">
                            Rp {{ number_format($subtotal,0,',','.') }}
                        </p>
                    </div>

                </div>
                @endforeach

            </div>

            {{-- RINGKASAN --}}
            {{-- Tambahan md:col-span-2 agar tampilan ringkasan presisi dengan list produk --}}
            <div class="md:col-span-2 bg-white p-6 rounded-2xl shadow-md h-fit sticky top-6">

                <h3 class="font-semibold text-lg mb-6">
                    Ringkasan Belanja
                </h3>

                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-medium">
                            Rp {{ number_format($total,0,',','.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span>Jumlah Item</span>
                        <span class="font-medium">
                            {{ $jumlahItem }} item
                        </span>
                    </div>
                </div>

                <hr class="my-5">

                <div class="flex justify-between items-center mb-5">
                    <span class="font-semibold text-lg">Total</span>
                    <span class="text-pink-600 font-bold text-xl">
                        Rp {{ number_format($total,0,',','.') }}
                    </span>
                </div>

                <a href="{{ route('checkout') }}"
                   class="block text-center bg-pink-600 text-white py-3 rounded-xl font-semibold hover:bg-pink-700 transition shadow">
                    Lanjut ke Pembayaran
                </a>
                
            </div>

        </div>

    {{-- Tampilan saat keranjang kosong --}}
    @else
        <div class="bg-white p-12 rounded-2xl shadow text-center flex flex-col items-center justify-center">
            <span class="text-6xl mb-4">🛒</span>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Keranjangmu masih kosong</h3>
            <p class="text-gray-500 mb-6">Yuk, cari produk menarik dan tambahkan ke keranjang!</p>
            <a href="{{ route('pelanggan.dashboard') }}" 
               class="bg-pink-600 text-white px-8 py-3 rounded-xl hover:bg-pink-700 transition shadow font-semibold">
                Mulai Belanja
            </a>
        </div>
    @endif

</div>
</body>
</html>