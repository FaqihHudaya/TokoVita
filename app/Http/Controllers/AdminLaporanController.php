<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kategori;


class AdminLaporanController extends Controller
{

public function exportPdf(Request $request)
{
    $filter = $request->filter ?? '30';

    $query = Pesanan::where('status','!=','dibatalkan');

    if ($filter == '7') {
        $query->whereDate('tanggal','>=',now()->subDays(7));
    } elseif ($filter == '30') {
        $query->whereDate('tanggal','>=',now()->subDays(30));
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
    public function index(Request $request)
    {
        $filter = $request->filter ?? '30';

        $query = Pesanan::where('status','!=','dibatalkan');

        if ($filter == '7') {
            $query->whereDate('tanggal','>=',Carbon::now()->subDays(7));
        } elseif ($filter == '30') {
            $query->whereDate('tanggal','>=',Carbon::now()->subDays(30));
        }

        $pesanan = $query->get();

        $totalPendapatan = $pesanan->sum('total_harga');
        $totalPesanan = $pesanan->count();
        $rataRata = $totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0;

        // Pendapatan per tanggal
        $chart = Pesanan::select(
                DB::raw('DATE(tanggal) as tanggal'),
                DB::raw('SUM(total_harga) as total')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal','asc')
            ->get();

        return view('admin.laporan.index', compact(
            'totalPendapatan',
            'totalPesanan',
            'rataRata',
            'chart',
            'filter'
        ));
    }
}