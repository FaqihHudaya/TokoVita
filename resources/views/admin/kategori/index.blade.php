@extends('layouts.admin')

@section('content')

<div class="p-6">

<div class="flex justify-between items-center mb-6">

<h1 class="text-2xl font-bold">
Kelola Kategori
</h1>

<button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg">

+ Tambah Kategori

</button>

</div>


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

@foreach($kategori as $k)

<div class="bg-white rounded-xl shadow p-6">

<div class="flex justify-between items-center mb-4">

<div class="bg-pink-100 text-pink-600 p-3 rounded-lg text-xl">
🏷
</div>

<div class="flex gap-3">

<button
onclick="editKategori('{{ $k->id_kategori }}','{{ $k->nama_kategori }}')"
class="text-blue-500 hover:text-blue-700">

✏

</button>

<form action="/admin/kategori/{{ $k->id_kategori }}" method="POST">

@csrf
@method('DELETE')

<button type="submit"
class="text-red-500 hover:text-red-700">

🗑

</button>

</form>

</div>

</div>

<h2 class="text-lg font-semibold mb-1">
{{ $k->nama_kategori }}
</h2>

<p class="text-gray-500 text-sm">

Total Produk
<span class="text-pink-500 font-semibold">

{{ $k->produk_count ?? 0 }}

</span>

</p>

</div>

@endforeach

</div>

</div>


<!-- Modal Tambah Kategori -->

<div id="modalTambah"
class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">

<div class="bg-white p-6 rounded-xl w-96">

<h2 class="text-lg font-bold mb-4">
Tambah Kategori
</h2>

<form action="/admin/kategori/store" method="POST">

@csrf

<input type="text"
name="nama_kategori"
class="w-full border p-2 rounded mb-4"
placeholder="Nama kategori"
required>

<div class="flex justify-end gap-2">

<button type="button"
onclick="document.getElementById('modalTambah').classList.add('hidden')"
class="px-4 py-2 border rounded">

Batal

</button>

<button class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded">

Simpan

</button>

</div>

</form>

</div>

</div>

@endsection