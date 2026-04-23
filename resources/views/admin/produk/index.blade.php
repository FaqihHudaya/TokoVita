<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - TokoVita Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-pink-50 min-h-screen font-sans text-gray-800">

    {{-- HEADER UTAMA (Tanpa Sidebar) --}}
    <header class="bg-white shadow-sm border-b border-pink-100 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-4">
                {{-- Tombol Kembali ke Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white transition">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div class="h-6 w-px bg-gray-200"></div>
                <h1 class="text-xl font-bold text-gray-800">Kelola Produk</h1>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500 font-medium">Admin TokoVita</span>
                <div class="w-10 h-10 rounded-full bg-pink-600 flex items-center justify-center text-white shadow-sm">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-6 mt-6">
        
        {{-- KOTAK ATAS: JUDUL & TOMBOL TAMBAH --}}
        <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6 mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-1">Daftar Produk</h2>
                <p class="text-gray-500 text-sm">Kelola semua barang dagangan, harga, dan stok di sini.</p>
            </div>
            
            {{-- Tombol Tambah Produk (Diarahkan ke halaman create) --}}
            <a href="{{ route('admin.produk.create') }}" class="bg-pink-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-pink-700 transition shadow-md shadow-pink-200 whitespace-nowrap flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Produk
            </a>
        </div>

        {{-- KOTAK BAWAH: TABEL PRODUK --}}
        <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-pink-50 to-white text-gray-500 text-sm uppercase tracking-wider border-b border-pink-100">
                            <th class="p-5 font-bold w-16 text-center">No</th>
                            <th class="p-5 font-bold">Produk</th>
                            <th class="p-5 font-bold">Kategori</th>
                            <th class="p-5 font-bold">Harga</th>
                            <th class="p-5 font-bold text-center">Stok</th>
                            <th class="p-5 font-bold text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        
                        {{-- Looping Data Produk --}}
                        @forelse($produk as $p)
                        <tr class="hover:bg-pink-50/50 transition group">
                            <td class="p-5 text-gray-400 font-medium text-center">{{ $loop->iteration }}</td>
                            
                            {{-- Info Produk (Gambar + Nama) --}}
                            <td class="p-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden border border-gray-200 flex-shrink-0">
                                        <img src="{{ asset('storage/'.$p->gambar) }}" alt="{{ $p->nama_produk }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="font-bold text-gray-800 group-hover:text-pink-600 transition line-clamp-2">
                                        {{ $p->nama_produk }}
                                    </div>
                                </div>
                            </td>

                            {{-- Nama Kategori --}}
                            <td class="p-5 font-medium text-gray-600">
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs border border-gray-200">
                                    {{ $p->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                                </span>
                            </td>

                            {{-- Harga & Diskon --}}
                            <td class="p-5">
                                @if($p->diskon > 0)
                                    <div class="font-bold text-gray-800">Rp {{ number_format($p->harga - ($p->harga * $p->diskon / 100), 0, ',', '.') }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs text-gray-400 line-through">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                                        <span class="text-[10px] bg-pink-100 text-pink-600 px-1.5 py-0.5 rounded font-bold">-{{ $p->diskon }}%</span>
                                    </div>
                                @else
                                    <div class="font-bold text-gray-800">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                                @endif
                            </td>

                            {{-- Stok (Warna merah jika habis) --}}
                            <td class="p-5 text-center">
                                @if($p->stok > 0)
                                    <span class="font-bold text-gray-800">{{ $p->stok }}</span>
                                @else
                                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs font-bold">Habis</span>
                                @endif
                            </td>
                            
                            {{-- Tombol Aksi --}}
                            <td class="p-5">
                                <div class="flex justify-center gap-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.produk.edit', $p->id_produk ?? $p->id) }}" class="w-9 h-9 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit Produk">
                                        <i class="fa-solid fa-pen text-sm"></i>
                                    </a>
                                    
                                    {{-- Form Hapus --}}
                                    <form action="{{ route('admin.produk.delete', $p->id_produk ?? $p->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus produk ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition shadow-sm" title="Hapus Produk">
                                            <i class="fa-solid fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        {{-- Tampilan Jika Data Kosong --}}
                        <tr>
                            <td colspan="6" class="p-16 text-center">
                                <div class="w-24 h-24 bg-pink-50 rounded-full flex items-center justify-center mx-auto mb-5 text-pink-300 text-4xl shadow-inner">
                                    <i class="fa-solid fa-box-open"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Produk</h3>
                                <p class="text-gray-500 text-sm mb-6">Toko kamu masih kosong. Yuk, tambahkan produk pertamamu sekarang!</p>
                                <a href="{{ route('admin.produk.create') }}" class="inline-block bg-pink-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-pink-700 transition">
                                    Tambah Produk
                                </a>
                            </td>
                        </tr>
                        @endforelse
                        
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>