<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\keranjang;
use App\Models\pesanan;
use App\Models\detailpesanan;
use Illuminate\Support\Facades\Auth;
use App\Models\Kategori;

class PelangganController extends Controller
{

private function hargaDiskon($produk)
{
    if ($produk->diskon > 0) {
        return $produk->harga - ($produk->harga * $produk->diskon / 100);
    }

    return $produk->harga;
}

public function detailProduk($id)
{
    $produk = Produk::findOrFail($id);

    return view('pelanggan.detail_produk', compact('produk'));
}

public function dashboard(Request $request)
{
    $kategori = Kategori::all();

    $produk = Produk::when($request->kategori, function ($query) use ($request) {
        $query->where('id_kategori', $request->kategori);
    })
    ->when($request->search, function ($query) use ($request) {
        $query->where('nama_produk', 'like', '%' . $request->search . '%');
    })
    ->get();

    $jumlahKeranjang = Keranjang::where('id_user', Auth::id())
                        ->sum('jumlah');

    $jumlahPesanan = Pesanan::where('id_user', Auth::id())
                        ->count();

    return view('pelanggan.dashboard', compact(
        'produk',
        'kategori',
        'jumlahKeranjang',
        'jumlahPesanan'
    ));
}

public function detailPesanan($id)
{
    $pesanan = Pesanan::where('id_pesanan',$id)
        ->where('id_user', Auth::id())
        ->firstOrFail();

    $detail = DetailPesanan::with('produk')
        ->where('id_pesanan',$id)
        ->get();

    return view('pelanggan.detail_pesanan',
        compact('pesanan','detail'));
}

public function pesanan()
{
    $pesanan = Pesanan::where('id_user', Auth::id())
        ->orderBy('id_pesanan','desc')
        ->get();

    return view('pelanggan.pesanan', compact('pesanan'));
}

public function riwayat()
{
    $pesanan = Pesanan::where('id_user', Auth::id())
                ->orderBy('id_pesanan','desc')
                ->get();

    return view('pelanggan.riwayat', compact('pesanan'));
}


public function prosesCheckout(Request $request)
{
    $keranjang = keranjang::with('produk')
                ->where('id_user', Auth::id())
                ->get();

foreach ($keranjang as $item) {
    if ($item->produk->stok < $item->jumlah) {
        return back()->with('error','Stok tidak mencukupi');
    }
}
    $total = 0;

    foreach ($keranjang as $item) {
       $harga = $this->hargaDiskon($item->produk);
       $total += $harga * $item->jumlah;
    }

    // 🔥 BUAT NOMOR ANTRIAN OTOMATIS
$last = pesanan::max('nomor_antrian');
$nomorAntrian = $last ? $last + 1 : 1;


    $pesanan = pesanan::create([
        'id_user' => Auth::id(),
        'nama_lengkap' => Auth::user()->nama,
'no_hp' => Auth::user()->no_telfon,
        'alamat' => $request->alamat,
         'catatan' => $request->catatan,
        'metode_penerimaan' => $request->metode_penerimaan,
        'total_harga' => $total,
        'total' => $total,
        'status' => 'menunggu',
        'nomor_antrian' => $nomorAntrian
    ]);

    foreach ($keranjang as $item) {

            $subtotal = $item->produk->harga * $item->jumlah;
            $harga = $this->hargaDiskon($item->produk);


        detailpesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_produk' => $item->id_produk,
            'jumlah' => $item->jumlah,
            'harga' => $harga,
            'subtotal' => $subtotal

        ]);
        
    // 🔥 KURANGI STOK OTOMATIS
    $produk = $item->produk;
    $produk->stok -= $item->jumlah;
    $produk->save();

    }

    keranjang::where('id_user', Auth::id())->delete();

    return redirect()->route('pelanggan.dashboard')
            ->with('success','Pesanan berhasil dibuat');
}


public function checkout()
{
    $keranjang = keranjang::with('produk')
                ->where('id_user', Auth::id())
                ->get();

    return view('pelanggan.checkout', compact('keranjang'));
}


public function lihatKeranjang()
{
    $keranjang = keranjang::with('produk')
                ->where('id_user', Auth::id())
                ->get();

    return view('pelanggan.keranjang', compact('keranjang'));
}


public function tambahKeranjang($id)
{
    $produk = produk::findOrFail($id);

    $cek = keranjang::where('id_user', Auth::id())
            ->where('id_produk', $id)
            ->first();

    if ($cek) {
        $cek->jumlah += 1;
        $cek->save();
    } else {
        keranjang::create([
            'id_user' => Auth::id(),
            'id_produk' => $id,
            'jumlah' => 1
        ]);
    }

return back()->with('success', 'Produk ditambahkan ke keranjang');
}

}
