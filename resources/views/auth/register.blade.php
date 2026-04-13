<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun🌸 </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center py-10
">

<div class="relative z-10 w-full max-w-xl bg-white p-8 rounded-2xl shadow-lg">

    
    <h2 class="text-2xl font-bold text-center mb-6">
        Daftar Akun 🌸
    </h2>
    @if ($errors->any())
    <div class="mb-4 text-red-500">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama -->
        <div class="mb-4">
            <label class="block mb-1">Nama Lengkap</label>
            <input type="text" name="nama"
                class="w-full border rounded-lg p-2"
                required>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email"
                class="w-full border rounded-lg p-2"
                required>
        </div>

        <!-- No Telp -->
        <div class="mb-4">
            <label class="block mb-1">No. Telepon</label>
            <input type="text" name="no_telfon"
                class="w-full border rounded-lg p-2"
                required>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="block mb-1">Password</label>
            <input type="password" name="password"
                class="w-full border rounded-lg p-2"
                required>
        </div>

        <!-- Konfirmasi -->
        <div class="mb-6">
            <label class="block mb-1">Konfirmasi Password</label>
            <input type="password"
                name="password_confirmation"
                class="w-full border rounded-lg p-2"
                required>
        </div>

        <button type="submit"
            class="w-full bg-pink-600 text-white py-2 rounded-lg hover:bg-pink-700 transition">
            Daftar
        </button>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-pink-600">
                Sudah punya akun? Masuk
            </a>
        </div>
    </form>
</div>


</body>

</html>