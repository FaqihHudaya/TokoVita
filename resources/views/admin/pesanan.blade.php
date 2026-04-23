<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan - TokoVita Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-pink-50 min-h-screen font-sans text-gray-800">

    {{-- HEADER UTAMA --}}
    <header class="bg-white shadow-sm border-b border-pink-100 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white transition shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div class="h-6 w-px bg-gray-200"></div>
                <h1 class="text-xl font-bold text-gray-800">Kelola Pesanan</h1>
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
        
        {{-- KOTAK ATAS: JUDUL & RINGKASAN STATUS --}}
        <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6 mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-1">Daftar Pesanan Masuk</h2>
                <p class="text-gray-500 text-sm">Pantau dan perbarui status pesanan dari pelanggan di sini.</p>
            </div>
            
            {{-- Info Ringkasan Status (3 Kartu: Menunggu, Diproses, Selesai) --}}
            <div class="flex flex-wrap justify-center gap-4">
                <div class="bg-orange-50 px-4 py-2 rounded-xl border border-orange-100 flex items-center gap-3">
                    <i class="fa-solid fa-clock text-orange-500"></i>
                    <div>
                        <p class="text-xs text-orange-600 font-bold uppercase">Menunggu</p>
                        <p class="text-lg font-extrabold text-orange-700">{{ $pesanan->where('status', 'menunggu')->count() }}</p>
                    </div>
                </div>
                <div class="bg-blue-50 px-4 py-2 rounded-xl border border-blue-100 flex items-center gap-3">
                    <i class="fa-solid fa-box-open text-blue-500"></i>
                    <div>
                        <p class="text-xs text-blue-600 font-bold uppercase">Diproses</p>
                        <p class="text-lg font-extrabold text-blue-700">{{ $pesanan->where('status', 'diproses')->count() }}</p>
                    </div>
                </div>
                {{-- Penambahan Status Selesai --}}
                <div class="bg-emerald-50 px-4 py-2 rounded-xl border border-emerald-100 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <div>
                        <p class="text-xs text-emerald-600 font-bold uppercase">Selesai</p>
                        <p class="text-lg font-extrabold text-emerald-700">{{ $pesanan->where('status', 'selesai')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABEL PESANAN --}}
        <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-pink-50 to-white text-gray-500 text-sm uppercase tracking-wider border-b border-pink-100">
                            <th class="p-5 font-bold w-16 text-center">No</th>
                            <th class="p-5 font-bold">ID Pesanan</th>
                            <th class="p-5 font-bold">Pelanggan</th>
                            <th class="p-5 font-bold">Waktu Pesan</th>
                            <th class="p-5 font-bold">Total Harga</th>
                            <th class="p-5 font-bold">Status</th>
                            <th class="p-5 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($pesanan as $p)
                        <tr class="hover:bg-pink-50/50 transition group">
                            <td class="p-5 text-gray-400 font-medium text-center">{{ $loop->iteration }}</td>
                            <td class="p-5">
                                <span class="font-bold text-pink-600 text-base">#{{ $p->id_pesanan }}</span>
                            </td>
                            <td class="p-5">
                                <div class="font-bold text-gray-800">{{ $p->nama_lengkap ?? optional($p->user)->nama ?? 'Guest' }}</div>
                                <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <i class="fa-solid fa-truck text-pink-400"></i> {{ $p->metode_penerimaan ?? 'Dikirim' }}
                                </div>
                            </td>
                            <td class="p-5 font-medium text-gray-600">
                                {{ \Carbon\Carbon::parse($p->tanggal ?? $p->created_at ?? now())->format('d M Y, H:i') }}
                            </td>
                            <td class="p-5 font-bold text-gray-800 text-base">
                                Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="p-5">
                                @if($p->status == 'selesai')
                                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-700 flex items-center w-fit gap-2 border border-emerald-200">
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Selesai
                                    </span>
                                @elseif($p->status == 'diproses')
                                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-100 text-blue-700 flex items-center w-fit gap-2 border border-blue-200">
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></div> Diproses
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-orange-100 text-orange-600 flex items-center w-fit gap-2 border border-orange-200">
                                        <div class="w-1.5 h-1.5 rounded-full bg-orange-500"></div> Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="p-5 text-center">
                                <a href="{{ route('admin.detailPesanan', $p->id_pesanan) }}" class="inline-flex items-center justify-center bg-white border-2 border-pink-100 text-pink-600 px-4 py-2 rounded-xl hover:bg-pink-600 hover:text-white hover:border-pink-600 transition font-bold shadow-sm text-xs gap-2">
                                    Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-16 text-center text-gray-500">Belum ada pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>