<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Checkout
        </h2>
    </x-slot>

    <div class="p-8 bg-gray-100 min-h-screen">

        @if(count($keranjang) > 0)

 <a href="{{ route('keranjang.index') }}"
class="text-pink-600 mb-6 inline-block">
← Kembali
</a>

        <div class="grid md:grid-cols-3 gap-6">

            {{-- FORM --}}
            <div class="md:col-span-2 bg-white p-6 rounded-xl shadow">

                <form action="{{ route('checkout.proses') }}" method="POST">
                    @csrf

                    <div class="mb-4">
    <label class="block font-semibold mb-1">Nama Lengkap</label>
    <div class="bg-gray-100 p-3 rounded-lg">
        {{ Auth::user()->nama }}
    </div>
</div>

                    <div class="mb-4">
    <label class="block font-semibold mb-1">No HP</label>
    <div class="bg-gray-100 p-3 rounded-lg">
        {{ Auth::user()->no_telfon }}
    </div>
</div>

                    <div class="mb-4">
    <label class="block mb-1 font-medium">Catatan</label>
    <textarea name="catatan"
        class="w-full border rounded-lg p-2"
        placeholder="Contoh: Tolong diapakan dulu "></textarea>
</div>

<div class="mb-6">

<label class="block mb-2 font-semibold">Metode Pembayaran</label>

<select name="metode_pembayaran" class="w-full border p-2 rounded">
    <option value="midtrans">E-Wallet/Bank </option>
    <option value="cod">Bayar di Tempat</option>
</select>

    <label class="block mb-3 font-semibold text-gray-800">Metode Penerimaan</label>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        {{-- Opsi 1: Dikirim ke Alamat --}}

        {{-- Opsi 2: Ambil di Toko --}}
        <label class="relative cursor-pointer group">
            <input type="radio" name="metode_penerimaan" value="Ambil di Toko" class="peer sr-only" required>
            
            <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-pink-600 peer-checked:bg-pink-50 hover:border-pink-300 transition-all flex items-start gap-4">
                
                {{-- Ikon Toko --}}
                <div class="text-gray-400 peer-checked:text-pink-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 0 0 3.75.615m-15 0a5.004 5.004 0 0 1 5.004-5.004h4.992a5.004 5.004 0 0 1 5.004 5.004m-15 0h15" />
                    </svg>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-800">Ambil di Toko</h4>
                    <p class="text-sm text-gray-500 mt-1">Ambil langsung di lokasi toko</p>
                </div>
            </div>
        </label>

    </div>
</div>

                    <button class="bg-pink-600 text-white px-6 py-3 rounded-xl hover:bg-pink-700">
                        Buat Pesanan
                    </button>

                </form>

            </div>

            {{-- RINGKASAN --}}
            <div class="bg-white p-6 rounded-xl shadow h-fit">

                <h3 class="font-semibold mb-4">Ringkasan Pesanan</h3>

                @php $total = 0; @endphp

                @foreach($keranjang as $item)
                    @php 
                         $harga = $item->produk->harga_diskon;
                         $subtotal = $harga * $item->jumlah;
                         $total += $subtotal;
                    @endphp

                    <div class="flex justify-between text-sm mb-2">
                        <span>{{ $item->produk->nama_produk }}</span>
                        <span>Rp {{ number_format($subtotal,0,',','.') }}</span>
                    </div>
                @endforeach

                <hr class="my-3">

                <div class="flex justify-between font-bold">
                    <span>Total</span>
                    <span class="text-pink-600">
                        Rp {{ number_format($total,0,',','.') }}
                    </span>
                </div>

            </div>            
        </div>

        @else

            <div class="bg-white p-6 rounded shadow text-center">
                Keranjang kosong.
            </div>

        @endif

    </div>
  @if(session('snap_token'))
<script>
    let snapToken = "{{ session('snap_token') }}";

    snap.pay(snapToken, {
        onSuccess: function(result){
            alert("Pembayaran berhasil!");
            window.location.href = "/riwayat";
        },
        onPending: function(result){
            alert("Menunggu pembayaran...");
            window.location.href = "/riwayat";
        },
        onError: function(result){
            alert("Pembayaran gagal!");
        },
        onClose: function(){
            alert("Kamu menutup pembayaran");
        }
    });
</script>
@endif
</body>
</html>