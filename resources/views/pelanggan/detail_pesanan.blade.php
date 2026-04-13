<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 p-8">

<h2 class="text-2xl font-bold mb-6">Detail Pesanan</h2>

<div class="bg-white p-6 rounded-xl shadow mb-6">

    <p class="font-bold text-lg mb-2">
        No Antrian #{{ $pesanan->nomor_antrian }}
    </p>

    <p><b>Status:</b> 
        @if($pesanan->status == 'menunggu')
            <span class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                Menunggu
            </span>
        @elseif($pesanan->status == 'diproses')
            <span class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                Diproses
            </span>
        @elseif($pesanan->status == 'selesai')
            <span class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                Selesai
            </span>
        @endif
    </p>

    <p class="mt-3"><b>Nama:</b> {{ $pesanan->nama_lengkap }}</p>
    <p><b>No HP:</b> {{ $pesanan->no_hp }}</p>
    <p><b>Alamat:</b> {{ $pesanan->alamat }}</p>
    <p><strong>Catatan:</strong> {{ $pesanan->catatan }}</p>
<p><strong>Metode Penerimaan:</strong> {{ $pesanan->metode_penerimaan }}</p>

</div>

<h3 class="text-lg font-semibold mb-3">Produk Dipesan:</h3>

@foreach($detail as $item)

<div class="bg-white p-4 rounded-xl shadow mb-4">

    <div class="flex justify-between">
        <p><b>{{ $item->produk->nama_produk }}</b></p>
        <p>x{{ $item->jumlah }}</p>
    </div>

    <p class="text-gray-500">
        Subtotal: Rp {{ number_format($item->subtotal,0,',','.') }}
    </p>

</div>

@endforeach

<div class="bg-white p-6 rounded-xl shadow mt-6">
    <p class="text-lg font-bold">
        Total: Rp {{ number_format($pesanan->total_harga,0,',','.') }}
    </p>
</div>

<a href="{{ route('pelanggan.dashboard') }}"
   class="inline-block mt-6 bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">
    Kembali ke Dashboard
</a>

</body>
</html>