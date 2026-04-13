<h1>Daftar Produk</h1>

@foreach($produk as $p)
<div style="border:1px solid #ddd; padding:10px; margin:10px;">
    <h3>{{ $p->nama_produk }}</h3>
    <p>Rp {{ $p->harga }}</p>
    <p>Stok: {{ $p->stok }}</p>
</div>
@endforeach