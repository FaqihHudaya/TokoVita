<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen">

    {{-- Navigasi / Header bisa diletakkan di sini --}}

    <div class="max-w-4xl mx-auto px-6 py-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-8">Riwayat Pesanan</h1>

        <div class="space-y-6">
            @forelse($pesanan as $p)
                {{-- KARTU PESANAN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                    
                    {{-- Header Kartu: Tanggal & Status --}}
                    <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-medium text-gray-500">
                                <i class="fa-solid fa-bag-shopping mr-1"></i> Belanja
                            </span>
                            <span class="text-sm text-gray-400">
                                {{ \Carbon\Carbon::parse($p->tanggal ?? $p->created_at)->translatedFormat('d F Y') }}
                            </span>
                            <span class="text-sm text-gray-400 bg-gray-100 px-2 py-0.5 rounded">
                                {{ $p->nomor_antrian ? 'Antrian: '.$p->nomor_antrian : 'ID: '.$p->id_pesanan }}
                            </span>
                        </div>

                        {{-- Label Status --}}
                        <div>
                            @if($p->status == 'selesai')
                                <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide">
                                    SELESAI
                                </span>
                            @elseif($p->status == 'diproses')
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide">
                                    DIPROSES
                                </span>
                            @else
                                {{-- Status Menunggu (Sesuai Request) --}}
                                <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-xs font-bold tracking-wide">
                                    MENUNGGU
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Body Kartu: Info Produk --}}
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        
                        {{-- Ambil detail produk pertama dari pesanan ini --}}
                        @php $firstDetail = $p->detail->first(); @endphp
                        
                        @if($firstDetail && $firstDetail->produk)
                        <div class="flex items-center gap-4 flex-1">
                            <img src="{{ asset('storage/'.$firstDetail->produk->gambar) }}" 
                                 alt="{{ $firstDetail->produk->nama_produk }}" 
                                 class="w-20 h-20 object-cover rounded-lg border border-gray-100">
                            
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg line-clamp-1">
                                    {{ $firstDetail->produk->nama_produk }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $firstDetail->jumlah }} barang x Rp {{ number_format($firstDetail->harga ?? ($firstDetail->subtotal / $firstDetail->jumlah), 0, ',', '.') }}
                                </p>
                                
                                {{-- Jika ada lebih dari 1 macam produk dalam 1 pesanan --}}
                                @if($p->detail->count() > 1)
                                    <p class="text-xs text-gray-400 mt-2">
                                        + {{ $p->detail->count() - 1 }} produk lainnya
                                    </p>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="flex-1 text-gray-500 text-sm italic">
                            Detail produk tidak ditemukan.
                        </div>
                        @endif

                        {{-- Total Harga & Aksi --}}
                        <div class="w-full md:w-auto border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6 text-right flex flex-row md:flex-col justify-between md:justify-center items-center md:items-end">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Total Belanja</p>
                                <p class="text-xl font-bold text-gray-800">
                                    Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Kartu: Tombol --}}
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('pelanggan.detailPesanan', $p->id_pesanan) }}" 
                           class="bg-white border border-pink-600 text-pink-600 hover:bg-pink-50 px-6 py-2 rounded-lg font-semibold text-sm transition shadow-sm">
                            Lihat Detail Pesanan
                        </a>
                    </div>

                </div>
            @empty
                {{-- Tampilan Jika Kosong --}}
                <div class="bg-white rounded-2xl shadow-sm p-12 text-center flex flex-col items-center justify-center border border-gray-100">
                    <span class="text-6xl mb-4">🛒</span>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada pesanan</h3>
                    <p class="text-gray-500 mb-6 text-sm">Riwayat pesananmu masih kosong. Yuk, mulai belanja sekarang!</p>
                    <a href="{{ route('pelanggan.dashboard') }}" class="bg-pink-600 text-white px-8 py-3 rounded-xl hover:bg-pink-700 transition font-semibold shadow-sm">
                        Mulai Belanja
                    </a>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>