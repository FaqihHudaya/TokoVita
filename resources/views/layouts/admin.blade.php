<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Admin Dashboard</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

<!-- Sidebar -->

<div class="w-64 bg-white shadow-lg p-6">

<h2 class="text-xl font-bold mb-6">
Admin Panel
</h2>

<ul class="space-y-4">

<li>
<a href="/admin/dashboard" class="hover:text-pink-500">
Dashboard
</a>
</li>

<li>
<a href="/admin/kategori" class="hover:text-pink-500">
Kelola Kategori
</a>
</li>

<li>
<a href="/admin/produk" class="hover:text-pink-500">
Kelola Produk
</a>
</li>

</ul>

</div>


<!-- Content -->

<div class="flex-1 p-8">

@yield('content')

</div>

</div>

</body>
</html>