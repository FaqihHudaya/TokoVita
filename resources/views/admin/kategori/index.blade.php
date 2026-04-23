<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - TokoVita Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-pink-50 min-h-screen font-sans text-gray-800">

    {{-- HEADER UTAMA (Tanpa Sidebar) --}}
    <header class="bg-white shadow-sm border-b border-pink-100 sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-4">
                {{-- Tombol Kembali ke Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white transition">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div class="h-6 w-px bg-gray-200"></div>
                <h1 class="text-xl font-bold text-gray-800">Kelola Kategori</h1>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500 font-medium">Admin TokoVita</span>
                <div class="w-10 h-10 rounded-full bg-pink-600 flex items-center justify-center text-white shadow-sm">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-6 mt-6">
        
        {{-- KOTAK ATAS: JUDUL & FORM TAMBAH (Desain Horizontal) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6 mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-1">Daftar Kategori</h2>
                <p class="text-gray-500 text-sm">Kelola pengelompokan produk tokomu di sini.</p>
            </div>
            
            {{-- Form Tambah Kategori --}}
            <form action="{{ url('admin/kategori/store') }}" method="POST" class="flex w-full md:w-auto gap-3">
                @csrf
                <div class="relative w-full md:w-72">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-tag text-gray-400"></i>
                    </div>
                    <input type="text" name="nama_kategori" required
                           class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 bg-gray-50 text-sm outline-none transition"
                           placeholder="Nama kategori baru...">
                </div>
                <button type="submit" class="bg-pink-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-pink-700 transition shadow-md shadow-pink-200 whitespace-nowrap flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah
                </button>
            </form>
        </div>

        {{-- KOTAK BAWAH: TABEL KATEGORI --}}
        <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-pink-50 to-white text-gray-500 text-sm uppercase tracking-wider border-b border-pink-100">
                            <th class="p-5 font-bold w-20 text-center">No</th>
                            <th class="p-5 font-bold">Nama Kategori</th>
                            <th class="p-5 font-bold text-center w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        
                        {{-- Looping Data Kategori --}}
                        @forelse($kategori as $k)
                        <tr class="hover:bg-pink-50/50 transition group">
                            <td class="p-5 text-gray-400 font-medium text-center">{{ $loop->iteration }}</td>
                            
                            <td class="p-5 font-bold text-gray-800 group-hover:text-pink-600 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-pink-100 text-pink-500 flex items-center justify-center">
                                        <i class="fa-solid fa-cube text-xs"></i>
                                    </div>
                                    {{ $k->nama_kategori }}
                                </div>
                            </td>
                            
                            <td class="p-5">
                                <div class="flex justify-center gap-3">
                                    {{-- Tombol Edit --}}
                                    <button class="w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit Kategori">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ url('admin/kategori/'.$k->id_kategori) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus kategori ({{ $k->nama_kategori }}) ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition shadow-sm" title="Hapus Kategori">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        {{-- Tampilan Jika Data Kosong --}}
                        <tr>
                            <td colspan="3" class="p-16 text-center">
                                <div class="w-24 h-24 bg-pink-50 rounded-full flex items-center justify-center mx-auto mb-5 text-pink-300 text-4xl shadow-inner">
                                    <i class="fa-solid fa-folder-open"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-1">Belum Ada Kategori</h3>
                                <p class="text-gray-500 text-sm">Silakan tambahkan kategori produk pertamamu melalui form di atas.</p>
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