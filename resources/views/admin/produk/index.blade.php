<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Produk</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<div class="p-8 bg-gray-100 min-h-screen">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Kelola Produk</h2>

        <a href="{{ route('admin.produk.create') }}"
           class="bg-pink-600 text-white px-5 py-2 rounded-lg hover:bg-pink-700 transition">
            + Tambah Produk
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <input type="text"
               placeholder="Cari produk..."
               class="w-full border rounded-lg px-4 py-2 mb-6">

        <table class="w-full text-left">

            <thead class="text-gray-500 border-b">
                <tr>
                    <th class="py-3">Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($produk as $item)
                <tr class="border-b hover:bg-gray-50">

                    <td class="py-4 flex items-center gap-4">
                        <img src="{{ asset('storage/'.$item->gambar) }}"
                             class="w-14 h-14 rounded-lg object-cover">

                        <div>
                            <div class="font-semibold">
                                {{ $item->nama_produk }}
                            </div>
                        </div>
                    </td>

<td>{{ $item->kategori->nama_kategori ?? '-' }}</td>

                    <td>Rp {{ number_format($item->harga,0,',','.') }}</td>

                    <td>
                        <form action="{{ route('admin.produk.update',$item->id_produk) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PUT')

                            <input type="number"
                                   name="stok"
                                   value="{{ $item->stok }}"
                                   class="w-20 border rounded px-2 py-1">

                            <button class="text-blue-500 hover:text-blue-700">
                                💾
                            </button>
                        </form>
                    </td>

                    <td class="text-center flex justify-center gap-3 py-4">

                        <a href="{{ route('admin.produk.edit',$item->id_produk) }}"
                           class="text-blue-500 hover:text-blue-700">
                            ✏
                        </a>

                        <form action="{{ route('admin.produk.delete',$item->id_produk) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:text-red-700">
                                🗑
                            </button>
                        </form>

                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>
</body>
</html>