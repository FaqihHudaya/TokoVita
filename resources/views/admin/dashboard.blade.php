<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="flex h-screen">

<!-- SIDEBAR -->
<div class="w-64 bg-white shadow-lg">

    <div class="p-6 border-b">
        <h1 class="text-2xl font-bold text-blue-600">
            Admin Panel
        </h1>
    </div>

    <nav class="p-4 space-y-2">

        <a href="{{ route('admin.dashboard') }}"
        class="block px-4 py-2 rounded bg-blue-100 text-blue-700 font-semibold">
        Dashboard
        </a>

        <a href="{{ route('admin.produk') }}"
        class="block px-4 py-2 rounded hover:bg-gray-100">
        Kelola Produk
        </a>

        <a href="{{ route('admin.pesanan') }}"
        class="block px-4 py-2 rounded hover:bg-gray-100">
        Kelola Pesanan
        </a>

        <a href="{{ route('admin.laporan') }}"
        class="block px-4 py-2 rounded hover:bg-gray-100">
        Laporan Penjualan
        </a>

        <a href="{{ route('admin.kategori') }}"
        class="block px-4 py-2 rounded hover:bg-gray-100">
        Kelola Kategori
        </a>

    </nav>

</div>


<!-- CONTENT -->
<div class="flex-1 flex flex-col">

<!-- TOPBAR -->
<div class="bg-white shadow px-6 py-4 flex justify-between items-center">

    <h2 class="text-xl font-semibold">
        Dashboard
    </h2>

    <div class="flex items-center gap-3">

        <span class="text-gray-600">
            Admin
        </span>

        <div class="w-8 h-8 bg-blue-500 text-white flex items-center justify-center rounded-full">
            A
        </div>

    </div>

</div>


<!-- MAIN CONTENT -->
<div class="p-6 overflow-y-auto">

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-6">
{{ session('success') }}
</div>
@endif


<!-- STATISTIC -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

<div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
<p class="text-gray-500">Total Pesanan</p>
<h2 class="text-3xl font-bold text-blue-600">
{{ $totalPesanan }}
</h2>
</div>


<div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
<p class="text-gray-500">Produk</p>
<h2 class="text-3xl font-bold text-purple-600">
{{ $totalProduk }}
</h2>
</div>


</div>


<div class="bg-white shadow rounded-xl p-6 mt-8">

<h2 class="text-lg font-semibold mb-4">
Produk Terlaris
</h2>

<table class="w-full text-left">

<thead>
<tr class="border-b">

<th class="py-2">Produk</th>
<th class="py-2">Harga</th>
<th class="py-2">Terjual</th>

</tr>
</thead>

<tbody>

@foreach($produkTerlaris as $produk)

<tr class="border-b hover:bg-gray-50">

<td class="py-2">
{{ $produk->nama_produk }}
</td>

<td class="py-2">
Rp {{ number_format($produk->harga) }}
</td>

<td class="py-2 font-semibold text-green-600">
{{ $produk->total_terjual }}
</td>

</tr>

@endforeach

</tbody>
</table>

</div>

</div>

</div>

</div>

</div>

</body>
</html>