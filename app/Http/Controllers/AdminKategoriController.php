<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class AdminKategoriController extends Controller
{

public function index()
{
    $kategori = Kategori::withCount('produk')->get();

    return view('admin.kategori.index',compact('kategori'));
}


public function store(Request $request)
{
    Kategori::create([
        'nama_kategori'=>$request->nama_kategori
    ]);

    return back()->with('success','Kategori berhasil ditambahkan');
}


public function update(Request $request,$id)
{
    $kategori = Kategori::find($id);

    $kategori->update([
        'nama_kategori'=>$request->nama_kategori
    ]);

    return back()->with('success','Kategori berhasil diupdate');
}


public function destroy($id)
{
    Kategori::find($id)->delete();

    return back()->with('success','Kategori berhasil dihapus');
}

}