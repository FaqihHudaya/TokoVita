<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Riwayat Pesanan</title>
@vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="container mx-auto px-6 py-10">

<h1 class="text-2xl font-bold mb-6">Riwayat Pesanan</h1>

<div class="bg-white rounded-xl shadow p-6">

<table class="w-full">

<thead class="border-b">

<tr class="text-left text-gray-500">

<th class="py-2">ORDER ID</th>
<th>TANGGAL</th>
<th>TOTAL</th>
<th>STATUS</th>
<th>DETAIL</th>

</tr>

</thead>

<tbody>

@forelse($pesanan as $p)

<tr class="border-b">

<td class="py-3">#{{ $p->id_pesanan }}</td>

<td>
{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}
</td>

<td>
Rp {{ number_format($p->total_harga,0,',','.') }}
</td>

<td>

@if($p->status == 'selesai')

<span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm">
Selesai
</span>

@elseif($p->status == 'diproses')

<span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm">
Diproses
</span>

@elseif($p->status == 'menunggu')

<span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-sm">
Menunggu
</span>

@endif

</td>

<td>

<a href="{{ route('pelanggan.detailPesanan',$p->id_pesanan) }}"
class="text-pink-600 font-semibold">

Detail

</a>

</td>

</tr>

@empty

<tr>

<td colspan="5" class="text-center py-10 text-gray-500">
Tidak Ada Riwayat Pesanan
</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</body>
</html>