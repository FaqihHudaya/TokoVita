<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-pink-50 flex items-center justify-center min-h-screen">

<div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">

    <h2 class="text-2xl font-bold text-center mb-6">
        Login Akun
    </h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email"
                class="w-full border rounded-lg p-2"
                required>
        </div>

        <!-- Password -->
        <div class="mb-6">
            <label class="block mb-1">Password</label>
            <input type="password" name="password"
                class="w-full border rounded-lg p-2"
                required>
        </div>

        <button type="submit"
            class="w-full bg-pink-600 text-white py-2 rounded-lg hover:bg-pink-700 transition">
            Login
        </button>

        <div class="text-center mt-4">
            <a href="{{ route('register') }}" class="text-sm text-pink-600">
                Belum punya akun? Daftar
            </a>
        </div>
    </form>
</div>

</body>
</html>
