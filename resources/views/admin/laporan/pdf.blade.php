<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>

<h2>Laporan Penjualan</h2>

<p>Total Pesanan: {{ $totalPesanan }}</p>
<p>Total Pendapatan: Rp {{ number_format($totalPendapatan,0,',','.') }}</p>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pesanan as $p)
        <tr>
            <td>{{ $p->tanggal }}</td>
            <td>Rp {{ number_format($p->total_harga,0,',','.') }}</td>
            <td>{{ $p->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>