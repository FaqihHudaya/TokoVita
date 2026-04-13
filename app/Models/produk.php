<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori',
        'nama_produk',
        'harga',
        'stok',
        'deskripsi',
        'gambar',
        'id_kategori',
        'stok',
        'diskon'
    ];


    public function getHargaDiskonAttribute()
{
    return $this->harga - ($this->harga * $this->diskon / 100);
}

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'id_produk');
    }
}