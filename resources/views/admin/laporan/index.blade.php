<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>
<div class="p-8 bg-gray-100 min-h-screen">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Laporan Penjualan</h2>
    </div>

</a>
    <!-- FILTER -->
     
    <div class="flex gap-3 mb-6">
        <a href="?filter=7"
           class="px-4 py-2 rounded-lg {{ $filter=='7'?'bg-gray-300':'bg-white' }}">
            7 Hari Terakhir
        </a>

        <a href="?filter=30"
           class="px-4 py-2 rounded-lg {{ $filter=='30'?'bg-pink-600 text-white':'bg-white' }}">
            30 Hari Terakhir
        </a>

        <a href="?filter=all"
           class="px-4 py-2 rounded-lg {{ $filter=='all'?'bg-gray-300':'bg-white' }}">
            Semua Waktu
        </a> 

        <a href="{{ route('admin.laporan.pdf', ['filter' => $filter]) }}"
           class="px-4 py-2 rounded-lg {{ $filter=='all'?'bg-gray-300':'bg-white' }}">
            Export PDF
        </a>       
    </div>

    

    <!-- CARD -->
     
    <div class="grid md:grid-cols-3 gap-6 mb-6">

        <div class="bg-white p-6 rounded-xl shadow">
            <div class="text-xl font-bold">
                Rp {{ number_format($totalPendapatan,0,',','.') }}
            </div>
            <div class="text-gray-500 text-sm">Total Pendapatan</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <div class="text-xl font-bold">{{ $totalPesanan }}</div>
            <div class="text-gray-500 text-sm">Total Pesanan</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <div class="text-xl font-bold">
                Rp {{ number_format($rataRata,0,',','.') }}
            </div>
            <div class="text-gray-500 text-sm">Rata-rata Nilai Pesanan</div>
        </div>

    </div>

    <!-- CHART -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-semibold mb-4">Pendapatan per Tanggal</h3>

        <canvas id="chart"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labels = @json($chart->pluck('tanggal'));
    const dataPendapatan = @json($chart->pluck('total'));

    const ctx = document.getElementById('chart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan',
                data: dataPendapatan,
                borderColor: '#ec4899',
                backgroundColor: 'rgba(236,72,153,0.1)',
                fill: true,
                tension: 0.4
            }]
        }
    });
</script>
</body>
</html>