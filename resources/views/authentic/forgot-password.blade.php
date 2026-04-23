<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-xl shadow w-full max-w-md">

    <h2 class="text-xl font-bold mb-6 text-center">Lupa Password</h2>

    @if(session('error'))
        <div class="bg-red-100 text-red-600 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/forgot-password">
        @csrf

        <label class="block mb-2">Email</label>
        <input type="email" name="email" required
            class="w-full border p-2 rounded mb-4">

        <button class="w-full bg-pink-600 text-white py-2 rounded hover:bg-pink-700">
            Kirim OTP
        </button>
    </form>

</div>

</body>
</html>