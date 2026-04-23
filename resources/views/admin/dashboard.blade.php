<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Toko Vita</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    {{-- Memanggil FontAwesome untuk Ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-pink-50 min-h-screen font-sans text-gray-800">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: `{{ session('success') }}`,
        confirmButtonText: 'OK'
    });
</script>
@endif

    <div class="flex h-screen overflow-hidden">
        
        {{-- SIDEBAR KIRI (Warna Pink Tua) --}}
        <aside class="w-64 bg-pink-600 text-white hidden md:flex flex-col shadow-xl z-20">
            <div class="h-20 flex items-center justify-center border-b border-pink-500">
                <h1 class="text-3xl font-extrabold tracking-wider">Toko<span class="text-pink-200">Vita</span></h1>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-3 overflow-y-auto">
                <a href="{{ route('admin.dashboard') ?? '#' }}" class="flex items-center gap-3 px-4 py-3 bg-pink-800 text-white rounded-xl font-semibold transition shadow-inner">
                    <i class="fa-solid fa-house w-5 text-center"></i> Dashboard
                </a>
                <a href="{{ route('admin.produk') ?? '#' }}" class="flex items-center gap-3 px-4 py-3 text-pink-100 hover:bg-pink-500 hover:text-white rounded-xl font-medium transition">
                    <i class="fa-solid fa-box-open w-5 text-center"></i> Kelola Produk
                </a>
                <a href="{{ route('admin.kategori') ?? '#' }}" class="flex items-center gap-3 px-4 py-3 text-pink-100 hover:bg-pink-500 hover:text-white rounded-xl font-medium transition">
                    <i class="fa-solid fa-tags w-5 text-center"></i> Kategori
                </a>
                <a href="{{ route('admin.pesanan') ?? '#' }}" class="flex items-center gap-3 px-4 py-3 text-pink-100 hover:bg-pink-500 hover:text-white rounded-xl font-medium transition">
                    <i class="fa-solid fa-cart-shopping w-5 text-center"></i> Pesanan
                </a>
                <a href="{{ route('admin.laporan') ?? '#' }}" class="flex items-center gap-3 px-4 py-3 text-pink-100 hover:bg-pink-500 hover:text-white rounded-xl font-medium transition">
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i> Laporan
                </a>
            </nav>
            <div class="p-4 border-t border-pink-500">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-pink-700 hover:bg-pink-800 text-white rounded-xl transition font-bold shadow">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- AREA KONTEN UTAMA --}}
        <main class="flex-1 flex flex-col overflow-y-auto">
            
            {{-- HEADER ATAS --}}
            <header class="h-20 bg-white shadow-sm flex items-center justify-between px-8 z-10 sticky top-0">
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-pink-600 text-2xl focus:outline-none">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h2 class="text-2xl font-bold text-gray-800">Ringkasan Sistem</h2>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-500 font-medium">Halo, <b>Admin</b>!</span>
                    <div class="w-10 h-10 rounded-full bg-pink-100 border-2 border-pink-500 flex items-center justify-center text-pink-600 font-bold overflow-hidden shadow-sm">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                </div>
            </header>

            {{-- KONTEN DASHBOARD --}}
            <div class="p-8">
                
                {{-- KARTU STATISTIK (4 Kolom) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    
                    {{-- Kartu 1: Total Produk --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-pink-100 flex items-center gap-5 hover:shadow-md transition group">
                        <div class="w-16 h-16 rounded-2xl bg-pink-50 flex items-center justify-center text-pink-500 text-3xl group-hover:bg-pink-500 group-hover:text-white transition">
                            <i class="fa-solid fa-box"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400 font-medium uppercase tracking-wider mb-1">Total Produk</p>
                            <p class="text-3xl font-extrabold text-gray-800">{{ $totalProduk ?? 120 }}</p>
                        </div>
                    </div>

                    {{-- Kartu 2: Pesanan Baru --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-pink-100 flex items-center gap-5 hover:shadow-md transition group">
                        <div class="w-16 h-16 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-500 text-3xl group-hover:bg-purple-500 group-hover:text-white transition">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400 font-medium uppercase tracking-wider mb-1">Pesanan Masuk</p>
                            <p class="text-3xl font-extrabold text-gray-800">{{ $totalPesanan ?? 45 }}</p>
                        </div>
                    </div>

                    {{-- Kartu 3: Total Pendapatan --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-pink-100 flex items-center gap-5 hover:shadow-md transition group">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-500 text-3xl group-hover:bg-emerald-500 group-hover:text-white transition">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400 font-medium uppercase tracking-wider mb-1">Pendapatan</p>
                            <p class="text-xl font-extrabold text-gray-800">Rp {{ number_format($totalPendapatan ?? 8500000, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Kartu 4: Total Pelanggan --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-pink-100 flex items-center gap-5 hover:shadow-md transition group">
                        <div class="w-16 h-16 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500 text-3xl group-hover:bg-orange-500 group-hover:text-white transition">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400 font-medium uppercase tracking-wider mb-1">Pelanggan</p>
                            <p class="text-3xl font-extrabold text-gray-800">{{ $totalPelanggan ?? 89 }}</p>
                        </div>
                    </div>

                </div>

                {{-- TABEL PESANAN TERBARU --}}
                <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
                    <div class="p-6 border-b border-pink-100 flex justify-between items-center bg-gradient-to-r from-pink-50 to-white">
                        <h3 class="text-lg font-bold text-gray-800"><i class="fa-solid fa-clock-rotate-left text-pink-500 mr-2"></i> Pesanan Terbaru</h3>
                        <a href="{{ route('admin.pesanan') ?? '#' }}" class="text-sm text-pink-600 font-semibold hover:text-pink-800 transition">Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i></a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white text-gray-400 text-sm uppercase tracking-wider border-b border-gray-100">
                                    <th class="p-5 font-semibold">ID Pesanan</th>
                                    <th class="p-5 font-semibold">Pelanggan</th>
                                    <th class="p-5 font-semibold">Tanggal</th>
                                    <th class="p-5 font-semibold">Total Harga</th>
                                    <th class="p-5 font-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-700">
    {{-- Looping data asli dari database --}}
    @forelse($pesananBaru as $pesanan)
    <tr class="border-b border-gray-50 hover:bg-pink-50/50 transition">
        {{-- ID Pesanan --}}
        <td class="p-5 font-bold text-pink-600">#{{ $pesanan->id_pesanan }}</td>
        
        {{-- Nama Pelanggan (Relasi ke tabel User) --}}
        <td class="p-5 font-medium">{{ $pesanan->user->nama ?? 'Pelanggan Dihapus' }}</td>
        
        {{-- Tanggal Pesanan (Format: 14 Apr 2026, 10:30) --}}
        <td class="p-5 text-gray-500">{{ \Carbon\Carbon::parse($pesanan->tanggal)->format('d M Y, H:i') }}</td>
        
        {{-- Total Harga --}}
        <td class="p-5 font-bold text-gray-800">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
        
        {{-- Status Pesanan (Menyesuaikan ENUM di Database) --}}
        <td class="p-5">
            @if($pesanan->status == 'selesai')
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Selesai</span>
            @elseif($pesanan->status == 'siap_diambil')
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">Siap Diambil</span>
            @elseif($pesanan->status == 'diproses')
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">Diproses</span>
            @else
                {{-- Default: Menunggu --}}
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-600">Menunggu</span>
            @endif
        </td>
    </tr>
    @empty
    {{-- Tampilan jika belum ada transaksi sama sekali --}}
    <tr>
        <td colspan="5" class="p-8 text-center text-gray-500">
            <i class="fa-solid fa-inbox text-3xl mb-3 text-pink-200 block"></i>
            Belum ada pesanan yang masuk.
        </td>
    </tr>
    @endforelse
</tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>
</html>