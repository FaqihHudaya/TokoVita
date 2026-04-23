<!DOCTYPE html>
<html lang="id">
<head>

<style>
html {
    scroll-behavior: smooth;
}
</style>

    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<!-- HEADER PINK FULL -->
<div class="flex justify-between items-center p-4">

{{-- Cek apakah ada session 'success' --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-lg border-l-4 border-green-500 z-50 transition-all duration-300" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
        </div>
        <div class="ms-3 text-sm font-normal text-gray-800">{{ session('success') }}</div>
        
        {{-- Tombol Tutup --}}
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" onclick="document.getElementById('toast-success').style.display='none'">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>

    {{-- Script untuk menghilangkan notifikasi otomatis setelah 5 detik --}}
    <script>
        setTimeout(function() {
            let toast = document.getElementById('toast-success');
            if(toast) {
                toast.style.transition = 'opacity 0.5s ease';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500); // Hapus elemen dari DOM setelah animasi
            }
        }, 5000); // 5000 milidetik = 5 detik
    </script>
@endif



    <!-- LOGO / NAMA -->
    <h1 class="text-xl font-bold text-pink-600">
        Toko Vita
</h1>

    <!-- MENU NAVBAR -->
<script>
function loadNotif() {
    fetch('/notif')
        .then(res => res.json())
        .then(data => {

            let notifBox = document.getElementById('notifBox');

            if (data.length > 0) {
                let html = '';

                data.forEach(item => {

                    let bgColor = '';
                    let textColor = '';
                    let pesan = '';
                    let icon = '';

                    let status = item.status.toLowerCase();

                    if (status === 'diproses') {
                        bgColor = 'bg-blue-100';
                        textColor = 'text-blue-700';
                        pesan = 'Pesanan anda sedang diproses, mohon ditunggu ya';
                        ;
                    } 
                    else if (status === 'selesai') {
                        bgColor = 'bg-green-100';
                        textColor = 'text-green-700';
                        pesan = 'Pesanan anda sudah dapat diambil di toko';
                        ;
                    }

                    html += `
                        <div class="${bgColor} ${textColor} p-3 rounded-lg mb-2 shadow-sm">
                            <div class="font-semibold">
                                ${icon} Antrian #${item.nomor_antrian}
                            </div>
                            <div class="text-sm mt-1">
                                ${pesan}
                            </div>
                        </div>
                    `;
                });

                notifBox.innerHTML = html;
            } else {
                notifBox.innerHTML = `
                    <div class="text-gray-500 text-sm">
                    </div>
                `;
            }
        });
}

// 🔁 reload tiap 5 detik
setInterval(loadNotif, 5000);

// pertama kali load
loadNotif();
</script>

<div id="notifBox" class="mb-4"></div>

    <!-- ICON KANAN -->
    <div class="flex items-center gap-4">

     <a href="{{ route('pelanggan.dashboard') }}"
           class="hover:text-pink-600 transition">
            Beranda
        </a>

        <a href="#produk"
           class="hover:text-pink-600 transition">
            Katalog
        </a>

        <a href="#promo"
           class="hover:text-pink-600 transition">
            Promo
        </a>

        <a href="#tentang"
           class="hover:text-pink-600 transition">
            Tentang
        </a>

@auth
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="hover:text-pink-600 transition">
            Logout
        </button>
    </form>
@else
    <a href="{{ route('login') }}"
       class="hover:text-pink-600 transition px-4 py-2 rounded-lg font-semibold">
        Login
    </a>
@endauth

        <!-- KERANJANG -->
        <a href="{{ route('keranjang.index') }}" class="relative">
            🛒
            @if($jumlahKeranjang > 0)
            <span class="absolute -top-3 -right-3 bg-red-600 text-white text-xs px-2 py-1 rounded-full">
                {{ $jumlahKeranjang }}
            </span>
            @endif
        </a>

        <!-- PESANAN -->
        <a href="{{ route('pelanggan.riwayat') }}" class="relative">
            📦
            @if($jumlahPesanan > 0)
            <span class="absolute -top-3 -right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full">
                {{ $jumlahPesanan }}
            </span>
            @endif
        </a>


    </div>

</div>

<div class="bg-gradient-to-r from-pink-400 to-pink-200 text-pink-600 text-center py-16">

    <h1 class="text-3xl font-bold">
        Promo Spesial April!
    </h1>

    <p class="mt-2">
        Diskon hingga 40% untuk produk kecantikan lokal pilihan
    </p>

    <button class="mt-4 bg-white text-pink-600 px-6 py-2 rounded-full font-semibold">
        Lihat Promo
    </button>

</div>

<div class="grid md:grid-cols-3 gap-6 px-8 py-6">

    <div class="bg-white p-4 rounded-xl shadow text-xl font-Bold text-pink-500 ">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
         <b>Flash Sale</b><br>
        Kejutan Diskon Spesial Untukmu!
    </div>

    <div class="bg-white p-4 rounded-xl shadow text-xl font-Bold text-pink-500 ">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
         <b>100% Produk Asli</b><br>
        Bersertifikat BPOM
    </div>

    <div class="bg-white p-4 rounded-xl shadow text-xl font-Bold text-pink-500 ">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
        <b>Konsultasi gratis</b><br>
        Chat beauty advisor
    </div>

</div>

<form method="GET" action="{{ route('pelanggan.dashboard') }}" class="mb-6">
    <input type="text" name="search"
        value="{{ request('search') }}"
        placeholder="Cari produk, brand, atau kategori..."
        class="w-full px-5 py-3 rounded-full border border-gray-200 shadow-sm focus:ring-2 focus:ring-pink-400 focus:outline-none">
</form>

<div class="px-8 mb-6">

    <h2 class="font-semibold mb-3">Kategori</h2>

    <div class="flex gap-3 flex-wrap">

        <!-- Semua -->
        <a href="{{ route('pelanggan.dashboard') }}"
        class="px-4 py-2 rounded-full border
        {{ request('kategori') ? 'bg-white' : 'bg-pink-600 text-white' }}">
        Semua
        </a>

        @foreach($kategori as $k)
        <a href="{{ route('pelanggan.dashboard',['kategori'=>$k->id_kategori]) }}"
        class="px-4 py-2 rounded-full border
        {{ request('kategori') == $k->id_kategori ? 'bg-pink-600 text-white' : 'bg-white' }}">
        {{ $k->nama_kategori }}
        </a>
        @endforeach

    </div>

</div>

<div class="px-8">

<div id="produk">
    <h2 class="text-xl font-bold mb-4">Produk Tersedia</h2>

<div class="grid grid-cols-2 md:grid-cols-4 gap-6">

@foreach($produk as $item)

<a href="{{ route('pelanggan.detailProduk', $item->id_produk) }}">

<div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition p-4 relative group">

    {{-- LABEL --}}
    <div class="absolute top-3 left-3 bg-pink-100 text-pink-600 text-xs px-2 py-1 rounded-full">
        Sale
    </div>

    {{-- WISHLIST --}}
    <div class="absolute top-3 right-3 bg-white p-2 rounded-full shadow text-gray-400">
        ❤️
    </div>

    {{-- GAMBAR --}}
    <img src="{{ asset('storage/' . $item->gambar) }}"
        class="rounded-lg mb-3 w-full h-44 object-cover">

    {{-- NAMA --}}
    <h3 class="text-sm font-medium text-gray-800 line-clamp-2">
        {{ $item->nama_produk }}
    </h3>

    {{-- RATING --}}
    <div class="text-yellow-400 text-sm mt-1">
        ⭐⭐⭐⭐☆
        <span class="text-gray-400 text-xs">(4.5)</span>
    </div>

    {{-- HARGA --}}
    @php
        $diskon = now()->month == 4 ? 20 : 0;
        $hargaAsli = $item->harga;
        $hargaDiskon = $hargaAsli - ($hargaAsli * $diskon / 100);
    @endphp

   @if($item->diskon > 0)
    <p class="text-pink-600 font-bold">
        Rp {{ number_format($item->harga_diskon,0,',','.') }}
    </p>
    <p class="text-gray-400 line-through text-sm">
        Rp {{ number_format($item->harga,0,',','.') }}
    </p>
@else
    <p class="text-pink-600 font-bold">
        Rp {{ number_format($item->harga,0,',','.') }}
    </p>
@endif
    {{-- STOK --}}
    <p class="text-gray-400 text-xs mt-1">
        Stok {{ $item->stok }}
    </p>

</div>
</a>

@endforeach

</div>
</div>
</div>



</body>
</html>

