<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Kategori;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter ?? '30';
        $kategori_id = $request->kategori_id ?? 'all';
        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_selesai = $request->tanggal_selesai;

        // Mulai Query dengan memanggil relasi detail pesanan
        $query = Pesanan::with('detail.produk')->where('status', '!=', 'dibatalkan');

        // 1. FILTER TANGGAL (VERSI PERBAIKAN WAKTU REAL)
        if ($tanggal_mulai && $tanggal_selesai) {
            // Kita tambahkan 00:00:00 untuk mulai dan 23:59:59 untuk selesai
            $query->where('tanggal', '>=', $tanggal_mulai . ' 00:00:00')
                  ->where('tanggal', '<=', $tanggal_selesai . ' 23:59:59');
            $filter = 'custom';
        } else {
            // Filter cepat bawaan
            if ($filter == '7') {
                $query->where('tanggal', '>=', Carbon::now()->subDays(7)->startOfDay());
            } elseif ($filter == '30') {
                $query->where('tanggal', '>=', Carbon::now()->subDays(30)->startOfDay());
            }
        }

        // 2. FILTER KATEGORI
        if ($kategori_id != 'all') {
            $query->whereHas('detail.produk', function($q) use ($kategori_id) {
                $q->where('id_kategori', $kategori_id);
            });
        }

        // Ambil Data
        $pesanan = $query->get();

        // Hitung Statistik
        $totalPendapatan = $pesanan->sum('total_harga');
        $totalPesanan = $pesanan->count();
        $rataRata = $totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0;

        // Persiapkan Data Chart (Grafik) secara otomatis sesuai filter
        $chartData = $pesanan->groupBy(function($item) {
            return Carbon::parse($item->tanggal ?? $item->created_at)->format('Y-m-d');
        })->map(function ($row) {
            return $row->sum('total_harga');
        });

        $labels = $chartData->keys();
        $dataPendapatan = $chartData->values();

        // Ambil list kategori untuk dropdown
        $kategoriList = Kategori::all();

        return view('admin.laporan.index', compact(
            'totalPendapatan',
            'totalPesanan',
            'rataRata',
            'labels',
            'dataPendapatan',
            'filter',
            'kategoriList',
            'kategori_id',
            'tanggal_mulai',
            'tanggal_selesai'
        ));
    }

    public function exportPdf(Request $request)
    {
        $filter = $request->filter ?? '30';
        $kategori_id = $request->kategori_id ?? 'all';
        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_selesai = $request->tanggal_selesai;

        $query = Pesanan::where('status', '!=', 'dibatalkan');

        // TERAPKAN JUGA PERBAIKAN WAKTU DI SINI AGAR PDF-NYA AKURAT
        if ($tanggal_mulai && $tanggal_selesai) {
            $query->where('tanggal', '>=', $tanggal_mulai . ' 00:00:00')
                  ->where('tanggal', '<=', $tanggal_selesai . ' 23:59:59');
        } else {
            if ($filter == '7') {
                $query->where('tanggal', '>=', Carbon::now()->subDays(7)->startOfDay());
            } elseif ($filter == '30') {
                $query->where('tanggal', '>=', Carbon::now()->subDays(30)->startOfDay());
            }
        }

        if ($kategori_id != 'all') {
            $query->whereHas('detail.produk', function($q) use ($kategori_id) {
                $q->where('id_kategori', $kategori_id);
            });
        }

        $pesanan = $query->get();
        $totalPendapatan = $pesanan->sum('total_harga');
        $totalPesanan = $pesanan->count();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact(
            'pesanan',
            'totalPendapatan',
            'totalPesanan'
        ));

        return $pdf->download('laporan-penjualan.pdf');
    }
}