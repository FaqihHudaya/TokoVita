<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Produk</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<div class="p-8 bg-gray-100 min-h-screen">

    <div class="mb-6">
        <h2 class="text-2xl font-bold">Edit Produk</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <form action="{{ route('admin.produk.update',$produk->id_produk) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 font-medium">Nama Produk</label>
                <input type="text"
                       name="nama_produk"
                       value="{{ $produk->nama_produk }}"
                       class="w-full border rounded-lg px-4 py-2"
                       required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Kategori</label>
                <select name="id_kategori"
                        class="w-full border rounded-lg px-4 py-2"
                        required>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id_kategori }}"
                            {{ $produk->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
    <label class="block font-semibold mb-1">Deskripsi Produk</label>
    <textarea name="deskripsi"
        class="w-full border p-2 rounded-lg"
        rows="4"
        placeholder="Masukkan deskripsi produk..."></textarea>
</div>

            <div>
                <label class="block mb-1 font-medium">Harga</label>
                <input type="number"
                       name="harga"
                       value="{{ $produk->harga }}"
                       class="w-full border rounded-lg px-4 py-2"
                       required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Stok</label>
                <input type="number"
                       name="stok"
                       value="{{ $produk->stok }}"
                       class="w-full border rounded-lg px-4 py-2"
                       required>
            </div>

            <input type="number" name="diskon" value="{{ $produk->diskon }}"
class="w-full p-2 border rounded">

            <div>
                <label class="block mb-1 font-medium">Gambar (Kosongkan jika tidak diganti)</label>
                <input type="file"
                       name="gambar"
                       class="w-full border rounded-lg px-4 py-2">

                <div class="mt-3">
                    <img src="{{ asset('storage/'.$produk->gambar) }}"
                         class="w-24 rounded-lg">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.produk') }}"
                   class="px-4 py-2 bg-gray-400 text-white rounded-lg">
                    Batal
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                    Update
                </button>
            </div>

        </form>

    </div>
</div>
</body>
</html>