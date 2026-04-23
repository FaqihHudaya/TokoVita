<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 p-8">

<h2 class="text-2xl font-bold mb-6">Detail Pesanan</h2>

<div class="bg-white p-6 rounded shadow mb-6">
    <p><b>Nama:</b> {{ $pesanan->nama_lengkap }}</p>
    <p><b>No HP:</b> {{ $pesanan->no_hp }}</p>
    <p><strong>Catatan:</strong> {{ $pesanan->catatan }}</p>
<p><strong>Metode Penerimaan:</strong> {{ $pesanan->metode_penerimaan }}</p>
<div class="mb-2">
    <span class="font-semibold">Metode Pembayaran:</span>
    
    <span class="px-3 py-1 rounded-full text-sm
        {{ $pesanan->metode_pembayaran == 'cod' 
            ? 'bg-yellow-100 text-yellow-700' 
            : 'bg-green-100 text-green-700' }}">
        
        {{ $pesanan->metode_pembayaran == 'cod' 
            ? 'COD (Bayar di Tempat)' 
            : 'E-wallet/Bank' }}
    </span>
</div>
    <p><b>Total:</b> Rp {{ number_format($pesanan->total_harga,0,',','.') }}</p>
</div>

<h3 class="text-lg font-semibold mb-3">Produk Dipesan:</h3>

@foreach($detail as $item)

<div class="bg-white p-4 rounded shadow mb-4">
    <p><b>Produk:</b> {{ $item->produk->nama_produk }}</p>
    <p><b>Jumlah:</b> {{ $item->jumlah }}</p>
    <p><b>Subtotal:</b> Rp {{ number_format($item->subtotal,0,',','.') }}</p>
</div>

@endforeach

{{-- 🔥 UBAH STATUS --}}
<div class="bg-white p-6 rounded shadow mt-6">
    <h3 class="font-semibold mb-3">Ubah Status</h3>

    <form action="{{ route('admin.updateStatus', $pesanan->id_pesanan) }}" method="POST">
        @csrf
        @method('PUT')

        <select name="status" class="border p-2 rounded mb-3">
            <option value="menunggu">Menunggu</option>
            <option value="diproses">Diproses</option>
            <option value="selesai">Selesai</option>
        </select>

        <button class="bg-pink-600 text-white px-4 py-2 rounded">
            Update Status
        </button>
    </form>
</div>

</body>
</html>
