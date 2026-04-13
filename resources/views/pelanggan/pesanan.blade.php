<!DOCTYPE html>
<html>
<head>
    <title>Pesanan Saya</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 p-8">

<h2 class="text-2xl font-bold mb-6">Pesanan Saya</h2>

@forelse($pesanan as $item)

<div class="bg-white p-6 rounded-xl shadow mb-6">

    <div class="flex justify-between items-center">

        <div>
            <p class="font-bold">No Antrian #{{ $item->nomor_antrian }}</p>
            <p class="text-gray-500 text-sm">
                Total: Rp {{ number_format($item->total_harga,0,',','.') }}
            </p>
        </div>

        <div>
            @if($item->status == 'menunggu')
                <span class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                    Menunggu
                </span>
            @elseif($item->status == 'diproses')
                <span class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                    Diproses
                </span>
            @elseif($item->status == 'selesai')
                <span class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                    Selesai
                </span>
            @endif
        </div>

    </div>

    <a href="{{ route('pelanggan.detailPesanan', $item->id_pesanan) }}"
       class="inline-block mt-4 bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700 transition">
        Lihat Detail
    </a>

</div>

@empty
<p class="text-gray-500">Belum ada pesanan.</p>
@endforelse

</body>
</html>