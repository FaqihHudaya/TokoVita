<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Produk</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>
<div class="p-8 bg-gray-100 min-h-screen">

    <div class="mb-6">
        <h2 class="text-2xl font-bold">Tambah Produk</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <form action="{{ route('admin.produk.store') }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">Nama Produk</label>
                <input type="text" 
                       name="nama_produk"
                       class="w-full border rounded-lg px-4 py-2"
                       required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Kategori</label>
                <select name="id_kategori"
                        class="w-full border rounded-lg px-4 py-2"
                        required>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id_kategori }}">
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

          <div class="mb-4">
    <label class="block font-semibold mb-1">Deskripsi</label>
    <textarea name="deskripsi"
        class="w-full border p-2 rounded"
        placeholder="Masukkan deskripsi produk"></textarea>
</div>

            <div>
                <label class="block mb-1 font-medium">Harga</label>
                <input type="number" 
                       name="harga"
                       class="w-full border rounded-lg px-4 py-2"
                       required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Stok</label>
                <input type="number" 
                       name="stok"
                       class="w-full border rounded-lg px-4 py-2"
                       required>
            </div>

            <input type="number" name="diskon" placeholder="Diskon (%)"
class="w-full p-2 border rounded">

            <div>
                <label class="block mb-1 font-medium">Gambar</label>
                <input type="file" 
                       name="gambar"
                       class="w-full border rounded-lg px-4 py-2"
                       required>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.produk') }}"
                   class="px-4 py-2 bg-gray-400 text-white rounded-lg">
                    Batal
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>
</body>
</html>