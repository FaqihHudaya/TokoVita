<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\DetailPesanan;

class KeranjangController extends Controller
{

public function checkoutProses(Request $request)
{

    // 1. Validasi input dari form
    $request->validate([
        'nama_lengkap' => 'required',
        'no_hp' => 'required',
        'alamat' => 'required',
        'metode_penerimaan' => 'required'
    ]);

    // 2. Ambil semua keranjang milik user
    $keranjang = Keranjang::where('id_user', Auth::id())->get();

    if ($keranjang->count() == 0) {
        return back()->with('error','Keranjang kosong');
    }

    // 3. Hitung total harga
    $total = 0;
    foreach ($keranjang as $item) {
        $total += $item->produk->harga * $item->jumlah;
    }

    // 4. Simpan ke tabel pesanan

    $nomorAntrian = Pesanan::max('nomor_antrian') + 1;

    $pesanan = Pesanan::create([
        'id_user' => Auth::id(),
        'nama_lengkap' => $request->nama_lengkap,
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat,
        'catatan' => $request->catatan,
        'metode_penerimaan' => $request->metode_penerimaan,
        'total_harga' => $total,
        'total' => $total,
        'status' => 'pending',
        'nomor_antrian' => $nomorAntrian
    ]);

    // 5. Simpan detail pesanan
    foreach ($keranjang as $item) {
        DetailPesanan::create([
            'id_pesanan' => $pesanan->id,
            'id_produk' => $item->id_produk,
            'jumlah' => $item->jumlah,
            'harga' => $item->produk->harga
        ]);
    }

    // 6. Hapus keranjang setelah checkout
    Keranjang::where('id_user', Auth::id())->delete();

    return redirect()->route('pelanggan.dashboard')
            ->with('success','Pesanan berhasil dibuat');
}

public function updateJumlah(Request $request, $id)
{
    $keranjang = Keranjang::findOrFail($id);

    $request->validate([
        'jumlah' => 'required|integer|min:1'
    ]);

    // Optional: cek stok
    if ($request->jumlah > $keranjang->produk->stok) {
        return back()->with('error','Stok tidak mencukupi');
    }

    $keranjang->jumlah = $request->jumlah;
    $keranjang->save();

    return back();
}

    public function hapus($id)
    {
        $keranjang = Keranjang::where('id_keranjang', $id)
                    ->where('id_user', Auth::id())
                    ->firstOrFail();

        $keranjang->delete();

        return back()->with('success','Produk dihapus dari keranjang');
    }
}
