<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Toko Vita 🌸 </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-pink-50 flex items-center justify-center min-h-screen">

<div class="text-center">

    <h1 class="text-4xl font-bold text-pink-600 mb-4">
        Selamat Datang di Toko Vita
    </h1>

    <p class="mb-8 text-gray-600">
        Website Pemesanan Produk Kecantikan
    </p>

    <div class="flex justify-center gap-4">

        <a href="{{ route('login') }}"
           class="px-6 py-2 bg-white border border-pink-600 text-pink-600 rounded-lg hover:bg-pink-100 transition">
            Login
        </a>

        <a href="{{ route('register') }}"
           class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition">
            Register
        </a>

    </div>

</div>

</body>
</html>