<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\pesanan;
use App\Models\detailpesanan;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{



public function dashboard()
{
    $totalProduk = Produk::count();
    $totalPesanan = Pesanan::count();
    $totalPendapatan = Pesanan::sum('total');

   $produkTerlaris = DB::table('detail_pesanan')
    ->join('produk', 'detail_pesanan.id_produk', '=', 'produk.id_produk')
    ->select(
        'produk.nama_produk',
        'produk.harga',
        DB::raw('SUM(detail_pesanan.jumlah) as total_terjual')
    )
    ->groupBy('produk.nama_produk', 'produk.harga')
    ->orderByDesc('total_terjual')
    ->limit(5)
    ->get();

     return view('admin.dashboard', compact(
        'totalProduk',
        'totalPesanan',
        'totalPendapatan',
        'produkTerlaris'
    ));
}

public function hapusProduk($id)
{
    $produk = produk::findOrFail($id);

    // hapus gambar dari storage
    if($produk->gambar){
        Storage::delete('public/' . $produk->gambar);
    }

    $produk->delete();

    return redirect()->route('admin.dashboard')
            ->with('success','Produk berhasil dihapus');
}

public function kelolaPesanan()
{
    $pesanan = pesanan::orderBy('id_pesanan','desc')->get();

    return view('admin.pesanan', compact('pesanan'));
}

public function detailPesanan($id)
{
    $pesanan = pesanan::findOrFail($id);

    $detail = detailpesanan::with('produk')
                ->where('id_pesanan', $id)
                ->get();

    return view('admin.detail_pesanan',
        compact('pesanan', 'detail'));
}

public function updateStatus(Request $request, $id)
{
    $pesanan = pesanan::findOrFail($id);

    $pesanan->status = $request->status;
    $pesanan->save();

    return redirect()->route('admin.dashboard')
            ->with('success','Status pesanan berhasil diperbarui');
}



public function pesanan()
{
$pesanan = pesanan::orderBy('id_pesanan', 'desc')->get();
    return view('admin.pesanan', compact('pesanan'));
}

    

    public function tambah(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'gambar' => 'required|image',
            'id_kategori' => 'required'

        ]);

        $gambar = $request->file('gambar')->store('produk', 'public');

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
                'stok' => $request->stok,
            'gambar' => $gambar,
            'deskripsi' => $request->deskripsi,
            'id_kategori' => $request->id_kategori

        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
    }
}
