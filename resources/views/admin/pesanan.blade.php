<!DOCTYPE html>
<html>
<head>
    <title>Kelola Pesanan</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 p-8">

<h2 class="text-2xl font-bold mb-6">Kelola Pesanan</h2>

@forelse($pesanan as $item)

<a href="{{ route('admin.detailPesanan', $item->id_pesanan) }}">

<div class="bg-white p-4 rounded shadow mb-4 hover:bg-gray-50 transition cursor-pointer">

    <div class="flex justify-between">
        <div>
            <p class="font-semibold">{{ $item->nama_lengkap }}</p>
            <p class="text-sm text-gray-600">
    Antrian: <b>#{{ $item->nomor_antrian }}</b>
</p>
            <p class="text-sm text-gray-500">
                Rp {{ number_format($item->total_harga,0,',','.') }}
            </p>
        </div>

        <div>
            @if($item->status == 'menunggu')
                <span class="text-yellow-500 font-semibold">Menunggu</span>
            @elseif($item->status == 'diproses')
                <span class="text-blue-500 font-semibold">Diproses</span>
            @else
                <span class="text-green-600 font-semibold">Selesai</span>
            @endif
        </div>
    </div>

</div>

</a>

@empty
<p>Tidak ada pesanan.</p>
@endforelse

</body>
</html>
