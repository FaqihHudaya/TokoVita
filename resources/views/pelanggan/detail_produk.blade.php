<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - {{ $produk->nama_produk }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">

{{-- Cek apakah ada session 'success' --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-lg border-l-4 border-green-500 z-50 transition-all duration-300" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
        </div>
        <div class="ms-3 text-sm font-normal text-gray-800">{{ session('success') }}</div>
        
        {{-- Tombol Tutup --}}
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" onclick="document.getElementById('toast-success').style.display='none'">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>

    {{-- Script untuk menghilangkan notifikasi otomatis setelah 5 detik --}}
    <script>
        setTimeout(function() {
            let toast = document.getElementById('toast-success');
            if(toast) {
                toast.style.transition = 'opacity 0.5s ease';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500); // Hapus elemen dari DOM setelah animasi
            }
        }, 5000); // 5000 milidetik = 5 detik
    </script>
@endif


    {{-- Gunakan navigasi/header kamu di sini jika ada (include/layout) --}}

    <div class="max-w-6xl mx-auto p-6 mt-8 bg-white rounded-2xl shadow-sm">

    <a href="{{ route('pelanggan.dashboard') }}"
class="text-pink-600 mb-6 inline-block">
← Kembali
</a>
        
        {{-- BAGIAN ATAS: FOTO & INFO PRODUK --}}
        <div class="grid md:grid-cols-2 gap-10">
            
            {{-- Kiri: Foto Produk --}}
            <div class="flex flex-col items-center">
                <div class="w-full bg-gray-100 rounded-xl aspect-square flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('storage/'.$produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="object-cover w-full h-full">
                </div>
                {{-- Opsi Thumbnail Gambar Kecil (Berdasarkan gambar referensimu) --}}
                <div class="flex gap-4 mt-4">
                    <div class="w-16 h-16 rounded-lg border-2 border-emerald-500 bg-gray-100 overflow-hidden cursor-pointer flex items-center justify-center">
                        <img src="{{ asset('storage/'.$produk->gambar) }}" class="object-cover w-full h-full">
                    </div>
                    <div class="w-16 h-16 rounded-lg border border-gray-200 bg-gray-100 cursor-pointer"></div>
                    <div class="w-16 h-16 rounded-lg border border-gray-200 bg-gray-100 cursor-pointer"></div>
                </div>
            </div>

            {{-- Kanan: Detail & Form Beli --}}
            <div class="flex flex-col justify-center">
                
                <h1 class="text-3xl font-bold text-gray-800 mb-3">{{ $produk->nama_produk }}</h1>
                
                {{-- Harga --}}
                <div class="mb-4">
                    @if($produk->diskon > 0)
                        <p class="text-3xl font-bold text-pink-600">Rp {{ number_format($produk->harga_diskon, 0, ',', '.') }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-sm line-through text-gray-400">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                            <span class="text-xs bg-pink-100 text-pink-600 px-2 py-0.5 rounded font-bold">-{{ $produk->diskon }}%</span>
                        </div>
                    @else
                        <p class="text-3xl font-bold text-pink-600">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    @endif
                </div>

                {{-- Tag / Label (Seperti di gambar) --}}
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="px-3 py-1 bg-teal-50 text-teal-700 rounded-full text-xs font-medium border border-teal-100">Anti hair fall</span>
                    <span class="px-3 py-1 bg-teal-50 text-teal-700 rounded-full text-xs font-medium border border-teal-100">Keratin formula</span>
                    <span class="px-3 py-1 bg-teal-50 text-teal-700 rounded-full text-xs font-medium border border-teal-100">Omega oil</span>
                    <span class="px-3 py-1 bg-teal-50 text-teal-700 rounded-full text-xs font-medium border border-teal-100">No paraben</span>
                    <span class="px-3 py-1 bg-teal-50 text-teal-700 rounded-full text-xs font-medium border border-teal-100">Dermatologically tested</span>
                </div>

                {{-- Deskripsi Singkat --}}
                <p class="text-gray-600 text-sm mb-8 leading-relaxed">
                    {{ $produk->deskripsi ?? 'Deskripsi produk belum tersedia.' }}
                </p>

                {{-- Form Add to Cart --}}
                <form action="{{ route('keranjang.tambah', ['id' => $produk->id_produk]) }}" method="POST">
                    @csrf
                    
                    {{-- Input Jumlah --}}
                    <div class="flex items-center gap-4 mb-8">
                        <span class="text-gray-600 font-medium">Jumlah:</span>
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden bg-white">
                            <button type="button" class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600" onclick="document.getElementById('jumlah_input').stepDown()">-</button>
                            <input type="number" id="jumlah_input" name="jumlah" value="1" min="1" max="{{ $produk->stok }}" class="w-12 text-center border-none focus:ring-0 text-gray-800 font-medium p-0" readonly>
                            <button type="button" class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600" onclick="document.getElementById('jumlah_input').stepUp()">+</button>
                        </div>
                        <span class="text-sm text-gray-400">Maks. {{ $produk->stok }}</span>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 bg-emerald-600 text-white px-6 py-3 rounded-lg flex items-center justify-center gap-2 font-semibold hover:bg-emerald-700 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            Masukkan ke keranjang
                        </button>
                        <button type="button" class="flex-1 bg-orange-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-600 transition shadow-sm">
                            Beli sekarang
                        </button>
                    </div>
                </form>

            </div>
        </div>

        {{-- BAGIAN BAWAH: TABS & DAFTAR ULASAN --}}
        <div class="mt-16 border-t border-gray-200 pt-8">
            
            {{-- Header Tab --}}
            <div class="flex gap-8 border-b border-gray-200 mb-8">
                <button class="pb-3 border-b-2 border-emerald-600 font-semibold text-emerald-700 text-lg">
                    Ulasan (128)
                </button>
                <button class="pb-3 text-gray-500 hover:text-gray-800 text-lg">
                    Pertanyaan
                </button>
                <button class="pb-3 text-gray-500 hover:text-gray-800 text-lg">
                    Produk serupa
                </button>
            </div>

            {{-- List Ulasan (Statis sementara sebagai template) --}}
            <div class="space-y-8">
                
                {{-- Ulasan 1 --}}
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg border border-blue-100">
                        SR
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h4 class="font-bold text-gray-800">Siti Rahayu</h4>
                            <div class="flex text-yellow-400">
                                @for($i=0; $i<5; $i++)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-400">2 hari lalu</span>
                        </div>
                        <p class="text-gray-600 leading-relaxed">
                            Bagus banget! Rambut jadi lebih lembut dan tidak rontok lagi setelah pakai 2 minggu. Wanginya juga segar dan tahan lama. Recommended!
                        </p>
                    </div>
                </div>

                {{-- Ulasan 2 --}}
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-lg border border-purple-100">
                        AN
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h4 class="font-bold text-gray-800">Anisa Nur</h4>
                            <div class="flex text-yellow-400">
                                @for($i=0; $i<5; $i++)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-400">5 hari lalu</span>
                        </div>
                        <p class="text-gray-600 leading-relaxed">
                            Produknya oke, rambut terasa lebih sehat. Pengiriman juga cepat dan packing aman. Harga terjangkau untuk kualitas segini.
                        </p>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</body>
</html>