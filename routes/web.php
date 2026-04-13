<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\AdminKategoriController;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// TAMBAH INI
Route::middleware(['auth'])->group(function () {
    Route::resource('produk', ProdukController::class);
});

Route::middleware(['auth'])->prefix('admin')->group(function () {


    Route::get('/pesanan', [AdminController::class, 'kelolaPesanan'])
        ->name('admin.pesanan');

    Route::get('/pesanan/{id}', [AdminController::class, 'detailPesanan'])
        ->name('admin.detailPesanan');

    Route::put('/pesanan/{id}', [AdminController::class, 'updateStatus'])
        ->name('admin.updateStatus');

    Route::delete('/produk/{id}', [AdminController::class, 'hapusProduk'])
        ->name('admin.hapusProduk');

    Route::post('/tambah-produk', [AdminController::class, 'tambah'])
        ->name('admin.tambahProduk');

    Route::get('/laporan', [AdminLaporanController::class, 'index'])
    ->name('admin.laporan');    

    Route::get('/admin/laporan/pdf', [AdminLaporanController::class, 'exportPdf'])
    ->name('admin.laporan.pdf');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard');

});

Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->group(function () {

    Route::get('/dashboard', [PelangganController::class, 'dashboard'])
    ->name('pelanggan.dashboard');

    Route::get('/checkout', [PelangganController::class, 'checkout'])
        ->name('checkout');

    Route::post('/checkout/proses', [PelangganController::class, 'prosesCheckout'])
        ->name('checkout.proses');

    Route::get('/pesanan-saya', [PelangganController::class, 'pesanan'])
        ->name('pelanggan.pesanan');

    Route::get('/pesanan-saya/{id}', [PelangganController::class, 'detailPesanan'])
        ->name('pelanggan.detailPesanan');

    Route::get('/riwayat',[PelangganController::class,'riwayat'])
->name('pelanggan.riwayat');    

Route::get('/produk/{id}', [PelangganController::class, 'detailProduk'])
->name('pelanggan.detailProduk');

});

Route::middleware(['auth', 'role:pelanggan'])->group(function () {

    Route::post('/keranjang/tambah/{id}', 
        [PelangganController::class, 'tambahKeranjang'])
        ->name('keranjang.tambah');

    Route::get('/keranjang', 
        [PelangganController::class, 'lihatKeranjang'])
        ->name('keranjang.index');

    Route::delete('/keranjang/{id}',
        [KeranjangController::class, 'hapus'])
        ->name('keranjang.hapus');

        Route::put('/keranjang/update/{id}',
    [KeranjangController::class, 'updateJumlah'])
    ->name('keranjang.update');

    Route::post('/checkout/proses', [KeranjangController::class, 'checkoutProses'])
    ->name('checkout.proses');

});

Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->group(function () {

    Route::get('/produk', [AdminProdukController::class, 'index'])->name('admin.produk');
    Route::get('/produk/create', [AdminProdukController::class, 'create'])->name('admin.produk.create');
    Route::post('/produk/store', [AdminProdukController::class, 'store'])->name('admin.produk.store');
    Route::get('/produk/edit/{id}', [AdminProdukController::class, 'edit'])->name('admin.produk.edit');
    Route::put('/produk/update/{id}', [AdminProdukController::class, 'update'])->name('admin.produk.update');
    
    Route::delete('/produk/delete/{id}', [AdminProdukController::class, 'destroy'])->name('admin.produk.delete');
});

Route::prefix('admin')->group(function () {

    Route::get('/kategori',[AdminKategoriController::class,'index'])->name('admin.kategori');

    Route::post('/kategori/store',[AdminKategoriController::class,'store']);

    Route::put('/kategori/{id}',[AdminKategoriController::class,'update']);

    Route::delete('/kategori/{id}',[AdminKategoriController::class,'destroy']);

});