<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - TokoVita Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-pink-50 min-h-screen font-sans text-gray-800">

    {{-- HEADER UTAMA (Tanpa Sidebar) --}}
    <header class="bg-white shadow-sm border-b border-pink-100 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white transition shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div class="h-6 w-px bg-gray-200"></div>
                <h1 class="text-xl font-bold text-gray-800">Laporan Penjualan</h1>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500 font-medium">Admin</span>
                <div class="w-10 h-10 rounded-full bg-pink-600 flex items-center justify-center text-white shadow-sm">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-6 mt-6">

        {{-- BARIS FILTER & EXPORT --}}
        <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6">
                
                {{-- Form Filter --}}
                <form action="{{ url('admin/laporan') }}" method="GET" class="flex flex-wrap items-end gap-4 w-full lg:w-auto">
                    
                    {{-- Filter Rentang Tanggal --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" value="{{ $tanggal_mulai }}" class="border-gray-200 rounded-xl focus:ring-pink-500 focus:border-pink-500 bg-gray-50 text-sm p-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" value="{{ $tanggal_selesai }}" class="border-gray-200 rounded-xl focus:ring-pink-500 focus:border-pink-500 bg-gray-50 text-sm p-2.5">
                    </div>

                    {{-- Filter Kategori --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kategori Produk</label>
                        <select name="kategori_id" class="border-gray-200 rounded-xl focus:ring-pink-500 focus:border-pink-500 bg-gray-50 text-sm p-2.5 min-w-[180px]">
                            <option value="all">Semua Kategori</option>
                            @foreach($kategoriList as $k)
                                <option value="{{ $k->id_kategori }}" {{ $kategori_id == $k->id_kategori ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Terapkan --}}
                    <button type="submit" class="bg-pink-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-pink-700 transition shadow-sm h-[42px]">
                        Terapkan Filter
                    </button>

                    {{-- Tombol Reset --}}
                    @if($filter == 'custom' || $kategori_id != 'all')
                        <a href="{{ url('admin/laporan') }}" class="text-pink-600 hover:underline text-sm font-medium mb-3 ml-2">Reset</a>
                    @endif
                </form>

                {{-- Tombol Export PDF --}}
                <div class="flex gap-2 w-full lg:w-auto border-t lg:border-t-0 pt-4 lg:pt-0">
                    <a href="{{ url('admin/laporan/pdf') }}?{{ http_build_query(request()->all()) }}" class="w-full lg:w-auto bg-gray-800 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-gray-900 transition shadow-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-file-pdf text-red-400"></i> Unduh PDF
                    </a>
                </div>
            </div>

            {{-- Filter Cepat (Quick Filters) --}}
            <div class="flex flex-wrap gap-2 mt-6 pt-4 border-t border-gray-100">
                <span class="text-sm text-gray-400 font-medium mr-2 flex items-center">Pintas Waktu:</span>
                <a href="{{ url('admin/laporan?filter=7&kategori_id='.$kategori_id) }}" class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $filter == '7' ? 'bg-pink-600 text-white shadow-md shadow-pink-200' : 'bg-pink-50 text-pink-600 hover:bg-pink-100' }}">7 Hari Terakhir</a>
                <a href="{{ url('admin/laporan?filter=30&kategori_id='.$kategori_id) }}" class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $filter == '30' ? 'bg-pink-600 text-white shadow-md shadow-pink-200' : 'bg-pink-50 text-pink-600 hover:bg-pink-100' }}">30 Hari Terakhir</a>
                <a href="{{ url('admin/laporan?filter=all&kategori_id='.$kategori_id) }}" class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $filter == 'all' ? 'bg-pink-600 text-white shadow-md shadow-pink-200' : 'bg-pink-50 text-pink-600 hover:bg-pink-100' }}">Semua Waktu</a>
            </div>
        </div>

        {{-- KARTU STATISTIK --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-pink-100 flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-500 text-2xl">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-medium uppercase tracking-wider mb-1">Total Pendapatan</p>
                    <p class="text-2xl font-extrabold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-pink-100 flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-500 text-2xl">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-medium uppercase tracking-wider mb-1">Total Pesanan</p>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $totalPesanan }} Trx</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-pink-100 flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-500 text-2xl">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-medium uppercase tracking-wider mb-1">Rata-rata Pesanan</p>
                    <p class="text-xl font-extrabold text-gray-800">Rp {{ number_format($rataRata, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- CHART / GRAFIK --}}
        <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-chart-area text-pink-500"></i> Grafik Pendapatan
            </h3>
            
            <div class="relative h-80 w-full">
                @if(count($labels) > 0)
                    <canvas id="chartPendapatan"></canvas>
                @else
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                        <i class="fa-solid fa-chart-pie text-4xl mb-3 text-pink-100"></i>
                        <p>Tidak ada data penjualan pada rentang filter ini.</p>
                    </div>
                @endif
            </div>
        </div>

    </main>

    {{-- SCRIPT CHART.JS --}}
    @if(count($labels) > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const labels = @json($labels);
            const dataPendapatan = @json($dataPendapatan);

            const ctx = document.getElementById('chartPendapatan').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: dataPendapatan,
                        borderColor: '#db2777', // Tailwind pink-600
                        backgroundColor: 'rgba(219, 39, 119, 0.15)', // Tailwind pink-600 transparent
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#db2777',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4 // Membuat garis melengkung halus
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6', // Tailwind gray-100
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
    @endif

</body>
</html>