<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\Kunjungan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HistoriTokoExport;

class HistoriTokoController extends Controller
{
    /**
     * Display histori for all toko
     */
    public function index()
    {
        $toko = Toko::orderBy('nama_toko')->get();
        return view('histori.index', compact('toko'));
    }

    /**
     * Get all histori data for DataTables
     */
    public function dataAll(Request $request)
    {
        $kunjungan = Kunjungan::with('toko')
            ->orderBy('tanggal_kunjungan', 'DESC');

        // Filter by toko
        if ($request->has('toko_id') && $request->toko_id != '') {
            $kunjungan->where('toko_id', $request->toko_id);
        }

        // Filter by date range
        if ($request->has('tanggal_awal') && $request->tanggal_awal != '') {
            $kunjungan->whereDate('tanggal_kunjungan', '>=', $request->tanggal_awal);
        }
        if ($request->has('tanggal_akhir') && $request->tanggal_akhir != '') {
            $kunjungan->whereDate('tanggal_kunjungan', '<=', $request->tanggal_akhir);
        }

        return DataTables::of($kunjungan->get())
            ->addIndexColumn()
            ->editColumn('tanggal_kunjungan', function ($kunjungan) {
                return tanggal_indonesia($kunjungan->tanggal_kunjungan, false);
            })
            ->addColumn('nama_toko', function ($kunjungan) {
                return $kunjungan->toko->nama_toko ?? '-';
            })
            ->addColumn('alamat_toko', function ($kunjungan) {
                return \Str::limit($kunjungan->toko->alamat ?? '-', 40);
            })
            ->editColumn('total_qty', function ($kunjungan) {
                return '<span class="badge badge-primary">'. $kunjungan->total_qty .' item</span>';
            })
            ->editColumn('total_nilai', function ($kunjungan) {
                return '<strong class="text-success">Rp. '. format_uang($kunjungan->total_nilai) .'</strong>';
            })
            ->addColumn('aksi', function ($kunjungan) {
                return '
                <button type="button" onclick="showDetail(`'. route('kunjungan.show', $kunjungan->id) .'`)" class="btn btn-xs btn-info btn-flat">
                    <i class="fa fa-eye"></i> Detail
                </button>
                ';
            })
            ->rawColumns(['total_qty', 'total_nilai', 'aksi'])
            ->make(true);
    }

    /**
     * Display histori for specific toko
     */
    public function show(string $id)
    {
        $toko = Toko::with(['kunjungan' => function($query) {
            $query->orderBy('tanggal_kunjungan', 'DESC');
        }])->findOrFail($id);

        // Get produk yang sering dibeli
        $produkSering = Produk::select('produk.*')
            ->join('kunjungan_details', 'produk.id', '=', 'kunjungan_details.produk_id')
            ->join('kunjungans', 'kunjungan_details.kunjungan_id', '=', 'kunjungans.id')
            ->where('kunjungans.toko_id', $id)
            ->selectRaw('SUM(kunjungan_details.qty) as total_qty')
            ->groupBy('produk.id')
            ->orderBy('total_qty', 'DESC')
            ->limit(5)
            ->get();

        // Statistics
        $totalKunjungan = $toko->kunjungan->count();
        $totalBelanja = $toko->kunjungan->sum('total_nilai');
        $rataRataBelanja = $totalKunjungan > 0 ? $totalBelanja / $totalKunjungan : 0;
        $kunjunganTerakhir = $toko->kunjungan->first();

        return view('histori.toko', compact(
            'toko',
            'produkSering',
            'totalKunjungan',
            'totalBelanja',
            'rataRataBelanja',
            'kunjunganTerakhir'
        ));
    }

    /**
     * Get histori data for specific toko (DataTables)
     */
    public function data(string $id, Request $request)
    {
        $kunjungan = Kunjungan::where('toko_id', $id)
            ->orderBy('tanggal_kunjungan', 'DESC');

        // Filter by date range
        if ($request->has('tanggal_awal') && $request->tanggal_awal != '') {
            $kunjungan->whereDate('tanggal_kunjungan', '>=', $request->tanggal_awal);
        }
        if ($request->has('tanggal_akhir') && $request->tanggal_akhir != '') {
            $kunjungan->whereDate('tanggal_kunjungan', '<=', $request->tanggal_akhir);
        }

        return DataTables::of($kunjungan->get())
            ->addIndexColumn()
            ->editColumn('tanggal_kunjungan', function ($kunjungan) {
                return tanggal_indonesia($kunjungan->tanggal_kunjungan, false);
            })
            ->editColumn('total_qty', function ($kunjungan) {
                return '<span class="badge badge-primary">'. $kunjungan->total_qty .' item</span>';
            })
            ->editColumn('total_nilai', function ($kunjungan) {
                return '<strong class="text-success">Rp. '. format_uang($kunjungan->total_nilai) .'</strong>';
            })
            ->addColumn('detail_produk', function ($kunjungan) {
                $html = '<ul class="list-unstyled mb-0">';
                foreach ($kunjungan->detail->take(3) as $detail) {
                    $html .= '<li><small>• '. $detail->produk->nama_produk .' ('. $detail->qty .'x)</small></li>';
                }
                if ($kunjungan->detail->count() > 3) {
                    $html .= '<li><small class="text-muted">... dan '. ($kunjungan->detail->count() - 3) .' lainnya</small></li>';
                }
                $html .= '</ul>';
                return $html;
            })
            ->addColumn('aksi', function ($kunjungan) {
                return '
                <button type="button" onclick="showDetail(`'. route('kunjungan.show', $kunjungan->id) .'`)" class="btn btn-xs btn-info btn-flat">
                    <i class="fa fa-eye"></i> Detail
                </button>
                ';
            })
            ->rawColumns(['total_qty', 'total_nilai', 'detail_produk', 'aksi'])
            ->make(true);
    }

    /**
     * Filter histori
     */
    public function filter(Request $request)
    {
        // Logic for filtering - can be expanded based on needs
        return redirect()->route('histori.index')->with($request->all());
    }

    /**
     * Export histori to Excel
     */
    public function exportExcel(Request $request)
    {
        $toko_id = $request->get('toko_id');
        $tanggal_awal = $request->get('tanggal_awal');
        $tanggal_akhir = $request->get('tanggal_akhir');

        $kunjungan = Kunjungan::with(['toko', 'detail.produk'])
            ->when($toko_id, function($query) use ($toko_id) {
                return $query->where('toko_id', $toko_id);
            })
            ->when($tanggal_awal, function($query) use ($tanggal_awal) {
                return $query->whereDate('tanggal_kunjungan', '>=', $tanggal_awal);
            })
            ->when($tanggal_akhir, function($query) use ($tanggal_akhir) {
                return $query->whereDate('tanggal_kunjungan', '<=', $tanggal_akhir);
            })
            ->orderBy('tanggal_kunjungan', 'DESC')
            ->get();

        $filename = 'histori-kunjungan-' . date('YmdHis') . '.xlsx';

        return Excel::download(new HistoriTokoExport($kunjungan), $filename);
    }

    /**
     * Export histori to PDF
     */
    public function exportPdf(Request $request)
    {
        $toko_id = $request->get('toko_id');
        $tanggal_awal = $request->get('tanggal_awal');
        $tanggal_akhir = $request->get('tanggal_akhir');

        $kunjungan = Kunjungan::with(['toko', 'detail.produk'])
            ->when($toko_id, function($query) use ($toko_id) {
                return $query->where('toko_id', $toko_id);
            })
            ->when($tanggal_awal, function($query) use ($tanggal_awal) {
                return $query->whereDate('tanggal_kunjungan', '>=', $tanggal_awal);
            })
            ->when($tanggal_akhir, function($query) use ($tanggal_akhir) {
                return $query->whereDate('tanggal_kunjungan', '<=', $tanggal_akhir);
            })
            ->orderBy('tanggal_kunjungan', 'DESC')
            ->get();

        $toko = null;
        if ($toko_id) {
            $toko = Toko::find($toko_id);
        }

        $totalNilai = $kunjungan->sum('total_nilai');
        $totalQty = $kunjungan->sum('total_qty');

        $pdf = Pdf::loadView('histori.pdf', compact(
            'kunjungan',
            'toko',
            'tanggal_awal',
            'tanggal_akhir',
            'totalNilai',
            'totalQty'
        ));

        $filename = 'histori-kunjungan-' . date('YmdHis') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Get statistics for dashboard or specific toko
     */
    public function getStatistics(Request $request)
    {
        $toko_id = $request->get('toko_id');
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        $query = Kunjungan::whereMonth('tanggal_kunjungan', $bulan)
            ->whereYear('tanggal_kunjungan', $tahun);

        if ($toko_id) {
            $query->where('toko_id', $toko_id);
        }

        $totalKunjungan = $query->count();
        $totalNilai = $query->sum('total_nilai');
        $rataRataNilai = $totalKunjungan > 0 ? $totalNilai / $totalKunjungan : 0;

        return response()->json([
            'total_kunjungan' => $totalKunjungan,
            'total_nilai' => $totalNilai,
            'rata_rata_nilai' => $rataRataNilai,
        ]);
    }

    /**
     * Get produk terlaris per toko
     */
    public function getProdukTerlaris(string $toko_id, Request $request)
    {
        $limit = $request->get('limit', 10);
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        $query = Produk::select('produk.*')
            ->join('kunjungan_details', 'produk.id', '=', 'kunjungan_details.produk_id')
            ->join('kunjungans', 'kunjungan_details.kunjungan_id', '=', 'kunjungans.id')
            ->where('kunjungans.toko_id', $toko_id);

        if ($bulan && $tahun) {
            $query->whereMonth('kunjungans.tanggal_kunjungan', $bulan)
                  ->whereYear('kunjungans.tanggal_kunjungan', $tahun);
        }

        $produk = $query->selectRaw('SUM(kunjungan_details.qty) as total_qty')
            ->selectRaw('SUM(kunjungan_details.subtotal) as total_nilai')
            ->groupBy('produk.id')
            ->orderBy('total_qty', 'DESC')
            ->limit($limit)
            ->get();

        return response()->json($produk);
    }
}
