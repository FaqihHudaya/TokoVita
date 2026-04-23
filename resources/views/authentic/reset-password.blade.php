<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-xl shadow w-full max-w-md">

    <h2 class="text-xl font-bold mb-6 text-center">Reset Password</h2>

    @if(session('error'))
        <div class="bg-red-100 text-red-600 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/reset-password">
        @csrf

        <label class="block mb-2">Password Baru</label>
        <input type="password" name="password" required
            class="w-full border p-2 rounded mb-4">

        <label class="block mb-2">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required
            class="w-full border p-2 rounded mb-6">

        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
            Simpan Password
        </button>
    </form>

</div>

</body>
</html>