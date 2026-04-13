<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;


class AdminProdukController extends Controller
{

    public function index()
    {
$produk = Produk::with('kategori')
                ->orderBy('id_produk', 'desc')
                ->get();
        return view('admin.produk.index', compact('produk'));
    }

    public function create()
    {
         $kategori = Kategori::all();
    return view('admin.produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'gambar' => 'required|image'
        ]);

        $gambar = $request->file('gambar')->store('produk', 'public');

        Produk::create([
            'nama_produk' => $request->nama_produk,
'id_kategori' => $request->id_kategori,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $gambar,
             'deskripsi' => $request->deskripsi,
             'diskon' => $request->diskon ?? 0,
        ]);

        return redirect()->route('admin.produk')->with('success','Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
            $kategori = Kategori::all();
    return view('admin.produk.edit', compact('produk','kategori'));
    }
public function update(Request $request, $id)
{
    $produk = Produk::findOrFail($id);

    // 🔥 Jika hanya update stok (dari tabel kelola produk)
    if ($request->has('stok') && !$request->has('nama_produk')) {

        $produk->stok = $request->stok;
        $produk->diskon = $request->diskon ?? 0;
        $produk->save();

        return back()->with('success','Stok berhasil diperbarui');
    }

    // 🔥 Jika update dari halaman edit produk
    $request->validate([
        'nama_produk' => 'required',
        'id_kategori' => 'required',
        'harga' => 'required|numeric',
        'stok' => 'required|numeric'
    ]);

    $produk->nama_produk = $request->nama_produk;
    $produk->id_kategori = $request->id_kategori;
    $produk->harga = $request->harga;
    $produk->stok = $request->stok;
    $produk->deskripsi = $request->deskripsi; 

    if ($request->hasFile('gambar')) {
        $gambar = $request->file('gambar')->store('produk','public');
        $produk->gambar = $gambar;
    }

    $produk->save();

    return redirect()->route('admin.produk')
            ->with('success','Produk berhasil diperbarui');
}

    public function destroy($id)
    {
        Produk::destroy($id);
        return back()->with('success','Produk dihapus');
    }
}