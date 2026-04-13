<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<!-- HEADER PINK FULL -->
<div class="bg-pink-600 text-white">

    <!-- TOP BAR -->
    <div class="flex justify-end p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="font-semibold text-white hover:text-pink-200">
                Logout
            </button>
        </form>
    </div>

    <!-- PROMO -->
    <div class="text-center py-10">
        <h1 class="text-3xl font-bold">Promo Spesial Februari!</h1>
        <p class="mt-2">Diskon hingga 30% untuk produk pilihan</p>

        <button class="mt-4 bg-white text-pink-600 px-6 py-2 rounded-full font-semibold">
            Lihat Promo
        </button>
    </div>

</div>


<div class="container mx-auto px-6 py-8">

    <!-- SEARCH -->
    <input type="text" placeholder="Cari produk..."
        class="w-full p-3 border rounded-lg mb-6">

    <!-- KATEGORI -->
    <h2 class="text-lg font-bold mb-2">Kategori</h2>
    <div class="flex gap-3 mb-6">
        <button class="bg-white border border-pink-600 text-pink-600 px-4 py-2 rounded-lg hover:bg-pink-50 transition">
            Skincare
        </button>
        <button class="bg-white border border-pink-600 text-pink-600 px-4 py-2 rounded-lg hover:bg-pink-50 transition">
            Makeup
        </button>
        <button class="bg-white border border-pink-600 text-pink-600 px-4 py-2 rounded-lg hover:bg-pink-50 transition">
            HairCare
        </button>
        <button class="bg-white border border-pink-600 text-pink-600 px-4 py-2 rounded-lg hover:bg-pink-50 transition">
            BodyCare
        </button>
        <button class="bg-white border border-pink-600 text-pink-600 px-4 py-2 rounded-lg hover:bg-pink-50 transition">
            Fragrance
        </button>
    </div>

    <!-- PRODUK -->
    <h2 class="text-xl font-bold mb-4">Produk Tersedia</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <!-- CARD -->
        <div class="bg-white rounded-xl shadow p-4">
            <img src="{{ asset('img/serum.jpeg') }}"
                class="rounded-lg mb-3 w-full h-40 object-cover">

            <h3 class="font-semibold">Vitamin C Serum</h3>
            <p class="text-pink-600 font-bold mt-2">Rp 150.000</p>

            <button class="mt-3 bg-pink-600 text-white px-4 py-2 rounded-lg w-full">
                + Keranjang
            </button>
        </div>

    </div>

</div>

</body>
</html>

