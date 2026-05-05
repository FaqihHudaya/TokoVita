<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; vertical-align: top; }
        th { background: #f2f2f2; text-align: left; }
        ul { margin: 0; padding-left: 15px; }
    </style>
</head>
<body>

<div style="width: 100%; margin-bottom: 20px;">
    <div style="text-align: right; font-size: 12px;">
        <strong>Dicetak oleh:</strong> {{ $user->nama ?? '-' }} <br>
        <strong>Waktu cetak:</strong> {{ $waktu->format('d-m-Y H:i') }}
    </div>
</div>

<h2>Laporan Penjualan</h2>

<p>Total Pesanan: {{ $totalPesanan }}</p>
<p>Total Pendapatan: Rp {{ number_format($totalPendapatan,0,',','.') }}</p>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pesanan as $p)
        <tr>
            <td>
                {{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}
            </td>

            <td>
                <ul>
                    @foreach($p->detail as $d)
                    <li>
                        {{ $d->produk->nama_produk ?? '-' }} 
                        ({{ $d->jumlah }}x) 
                        = Rp {{ number_format(($d->harga ?? $d->produk->harga ?? 0) * $d->jumlah,0,',','.') }}
                    </li>
                    @endforeach
                </ul>
            </td>

            <td>
                Rp {{ number_format($p->total_harga,0,',','.') }}
            </td>

            <td>{{ $p->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>