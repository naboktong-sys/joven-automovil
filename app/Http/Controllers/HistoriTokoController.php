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
     * Halaman histori seluruh kunjungan (dengan filter toko & tanggal)
     */
    public function index()
    {
        $toko = Toko::orderBy('nama_toko')->get();
        return view('histori.index', compact('toko'));
    }

    /**
     * Data histori semua toko untuk DataTables
     */
    public function dataAll(Request $request)
    {
        $kunjungan = $this->filteredQuery($request)->with('toko')->get();

        return DataTables::of($kunjungan)
            ->addIndexColumn()
            ->editColumn('tanggal_kunjungan', function ($kunjungan) {
                return tanggal_indonesia($kunjungan->tanggal_kunjungan->format('Y-m-d'), false);
            })
            ->addColumn('nama_toko', function ($kunjungan) {
                return e($kunjungan->toko->nama_toko ?? '-');
            })
            ->addColumn('alamat_toko', function ($kunjungan) {
                return e(\Str::limit($kunjungan->toko->alamat ?? '-', 40));
            })
            ->editColumn('total_qty', function ($kunjungan) {
                return '<span class="badge badge-primary">'. $kunjungan->total_qty .' item</span>';
            })
            ->editColumn('total_nilai', function ($kunjungan) {
                return '<strong class="text-success">Rp. '. format_uang($kunjungan->total_nilai) .'</strong>';
            })
            ->addColumn('aksi', function ($kunjungan) {
                return '
                <a href="'. route('kunjungan.show', $kunjungan->id) .'" class="btn btn-xs btn-info btn-flat">
                    <i class="fa fa-eye"></i> Detail
                </a>
                ';
            })
            ->rawColumns(['total_qty', 'total_nilai', 'aksi'])
            ->make(true);
    }

    /**
     * Halaman histori satu toko
     */
    public function show(string $id)
    {
        $toko = Toko::with(['kunjungan' => function ($query) {
            $query->orderBy('tanggal_kunjungan', 'DESC');
        }])->findOrFail($id);

        // Produk yang paling sering dibeli toko ini
        $produkSering = Produk::query()
            ->join('kunjungan_details', 'produk.id_produk', '=', 'kunjungan_details.produk_id')
            ->join('kunjungans', 'kunjungan_details.kunjungan_id', '=', 'kunjungans.id')
            ->where('kunjungans.toko_id', $id)
            ->selectRaw('produk.id_produk, produk.kode_produk, produk.nama_produk, produk.merk, SUM(kunjungan_details.qty) as total_qty, SUM(kunjungan_details.subtotal) as total_nilai')
            ->groupBy('produk.id_produk', 'produk.kode_produk', 'produk.nama_produk', 'produk.merk')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

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
     * Data histori satu toko untuk DataTables
     */
    public function data(string $id, Request $request)
    {
        $request->merge(['toko_id' => $id]);

        $kunjungan = $this->filteredQuery($request)->with('detail.produk')->get();

        return DataTables::of($kunjungan)
            ->addIndexColumn()
            ->editColumn('tanggal_kunjungan', function ($kunjungan) {
                return tanggal_indonesia($kunjungan->tanggal_kunjungan->format('Y-m-d'), false);
            })
            ->editColumn('total_qty', function ($kunjungan) {
                return '<span class="badge badge-primary">'. $kunjungan->total_qty .' item</span>';
            })
            ->editColumn('total_nilai', function ($kunjungan) {
                return '<strong class="text-success">Rp. '. format_uang($kunjungan->total_nilai) .'</strong>';
            })
            ->addColumn('detail_produk', function ($kunjungan) {
                $html = '<ul class="list-unstyled" style="margin:0">';
                foreach ($kunjungan->detail->take(3) as $detail) {
                    $html .= '<li><small>• '. e($detail->produk->nama_produk ?? '(produk dihapus)') .' ('. $detail->qty .'x)</small></li>';
                }
                if ($kunjungan->detail->count() > 3) {
                    $html .= '<li><small class="text-muted">... dan '. ($kunjungan->detail->count() - 3) .' lainnya</small></li>';
                }
                $html .= '</ul>';
                return $html;
            })
            ->addColumn('aksi', function ($kunjungan) {
                return '
                <a href="'. route('kunjungan.show', $kunjungan->id) .'" class="btn btn-xs btn-info btn-flat">
                    <i class="fa fa-eye"></i> Detail
                </a>
                ';
            })
            ->rawColumns(['total_qty', 'total_nilai', 'detail_produk', 'aksi'])
            ->make(true);
    }

    /**
     * Export histori ke Excel
     */
    public function exportExcel(Request $request)
    {
        $kunjungan = $this->filteredQuery($request)->with(['toko', 'detail.produk'])->get();

        return Excel::download(
            new HistoriTokoExport($kunjungan),
            'histori-kunjungan-' . date('YmdHis') . '.xlsx'
        );
    }

    /**
     * Export histori ke PDF
     */
    public function exportPdf(Request $request)
    {
        $kunjungan = $this->filteredQuery($request)->with(['toko', 'detail.produk'])->get();

        $toko = $request->filled('toko_id') ? Toko::find($request->toko_id) : null;
        $tanggal_awal = $request->get('tanggal_awal');
        $tanggal_akhir = $request->get('tanggal_akhir');
        $totalNilai = $kunjungan->sum('total_nilai');
        $totalQty = $kunjungan->sum('total_qty');

        $pdf = Pdf::loadView('histori.pdf', compact(
            'kunjungan',
            'toko',
            'tanggal_awal',
            'tanggal_akhir',
            'totalNilai',
            'totalQty'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('histori-kunjungan-' . date('YmdHis') . '.pdf');
    }

    /**
     * Query dasar kunjungan dengan filter toko_id, tanggal_awal, tanggal_akhir
     */
    private function filteredQuery(Request $request)
    {
        return Kunjungan::query()
            ->when($request->filled('toko_id'), function ($q) use ($request) {
                $q->where('toko_id', $request->toko_id);
            })
            ->when($request->filled('tanggal_awal'), function ($q) use ($request) {
                $q->whereDate('tanggal_kunjungan', '>=', $request->tanggal_awal);
            })
            ->when($request->filled('tanggal_akhir'), function ($q) use ($request) {
                $q->whereDate('tanggal_kunjungan', '<=', $request->tanggal_akhir);
            })
            ->orderBy('tanggal_kunjungan', 'DESC')
            ->orderBy('id', 'DESC');
    }
}
