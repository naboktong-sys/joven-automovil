<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\KunjunganDetail;
use App\Models\Toko;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class KunjunganController extends Controller
{
    public function index()
    {
        $toko = Toko::orderBy('nama_toko')->get();
        return view('kunjungan.index', compact('toko'));
    }

    public function data(Request $request)
    {
        $kunjungan = Kunjungan::with('toko')
            ->orderBy('tanggal_kunjungan', 'DESC')
            ->orderBy('created_at', 'DESC');

        if ($request->filled('toko_id')) {
            $kunjungan->where('toko_id', $request->toko_id);
        }
        if ($request->filled('tanggal_awal')) {
            $kunjungan->whereDate('tanggal_kunjungan', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $kunjungan->whereDate('tanggal_kunjungan', '<=', $request->tanggal_akhir);
        }

        return DataTables::of($kunjungan->get())
            ->addIndexColumn()
            ->editColumn('tanggal_kunjungan', fn($k) => tanggal_indonesia($k->tanggal_kunjungan, false))
            ->addColumn('nama_toko', fn($k) => $k->toko->nama_toko ?? '-')
            ->editColumn('total_qty', fn($k) => '<span class="badge badge-primary">'. $k->total_qty .' item</span>')
            ->editColumn('total_nilai', fn($k) => '<strong class="text-success">Rp. '. format_uang($k->total_nilai) .'</strong>')
            ->addColumn('aksi', function ($k) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="showDetail(`'. route('kunjungan.show', $k->id) .'`)" class="btn btn-xs btn-info btn-flat" title="Detail">
                        <i class="fa fa-eye"></i> Detail
                    </button>
                    <button type="button" onclick="editData(`'. $k->id .'`, `'. route('kunjungan.edit.data', $k->id) .'`)" class="btn btn-xs btn-warning btn-flat" title="Edit">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <button type="button" onclick="deleteData(`'. route('kunjungan.destroy', $k->id) .'`)" class="btn btn-xs btn-danger btn-flat" title="Hapus">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>';
            })
            ->rawColumns(['total_qty', 'total_nilai', 'aksi'])
            ->make(true);
    }

    public function create()
    {
        $toko   = Toko::orderBy('nama_toko')->get();
        $produk = Produk::where('stok', '>', 0)->orderBy('nama_produk')->get();
        return view('kunjungan.create', compact('toko', 'produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'toko_id'              => 'required|exists:tokos,id',
            'tanggal_kunjungan'    => 'required|date',
            'catatan'              => 'nullable|string',
            'foto_kunjungan'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'produk'               => 'required|array|min:1',
            'produk.*.produk_id'   => 'required|integer',
            'produk.*.qty'         => 'required|integer|min:1',
        ], [
            'produk.required' => 'Minimal harus ada 1 produk yang dibeli',
            'produk.*.qty.min' => 'Qty harus minimal 1',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'toko_id'           => $request->toko_id,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'catatan'           => $request->catatan,
                'total_qty'         => 0,
                'total_nilai'       => 0,
            ];

            if ($request->hasFile('foto_kunjungan')) {
                $file     = $request->file('foto_kunjungan');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/kunjungan', $filename);
                $data['foto_kunjungan'] = $filename;
            }

            $kunjungan = Kunjungan::create($data);

            // ✅ MERGE produk duplikat sebelum diproses
            $produkMerged = [];
            foreach ($request->produk as $item) {
                $pid = $item['produk_id'];
                if (isset($produkMerged[$pid])) {
                    $produkMerged[$pid]['qty'] += (int) $item['qty'];
                } else {
                    $produkMerged[$pid] = ['produk_id' => $pid, 'qty' => (int) $item['qty']];
                }
            }

            $totalQty   = 0;
            $totalNilai = 0;

            foreach ($produkMerged as $item) {
                $produk = Produk::where('id_produk', $item['produk_id'])->first();

                if (!$produk) {
                    throw new \Exception("Produk dengan ID {$item['produk_id']} tidak ditemukan");
                }
                if ($produk->stok < $item['qty']) {
                    throw new \Exception("Stok {$produk->nama_produk} tidak mencukupi. Stok tersedia: {$produk->stok}");
                }

                $subtotal = $produk->harga_jual * $item['qty'];

                KunjunganDetail::create([
                    'kunjungan_id' => $kunjungan->id,
                    'produk_id'    => $produk->id_produk,
                    'qty'          => $item['qty'],
                    'harga'        => $produk->harga_jual,
                    'subtotal'     => $subtotal,
                ]);

                $produk->stok -= $item['qty'];
                $produk->save();

                $totalQty   += $item['qty'];
                $totalNilai += $subtotal;
            }

            $kunjungan->update([
                'total_qty'   => $totalQty,
                'total_nilai' => $totalNilai,
            ]);

            DB::commit();

            return redirect()->route('kunjungan.show', $kunjungan->id)
                ->with('success', 'Kunjungan berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan kunjungan: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $kunjungan = Kunjungan::with(['toko', 'detail.produk'])->findOrFail($id);
        return view('kunjungan.detail', compact('kunjungan'));
    }

    public function detailData(string $id)
    {
        $detail = KunjunganDetail::with('produk')
            ->where('kunjungan_id', $id)
            ->get();

        return DataTables::of($detail)
            ->addIndexColumn()
            ->addColumn('id', fn($d) => $d->id)
            ->addColumn('nama_produk', fn($d) => $d->produk->nama_produk ?? '-')
            ->addColumn('kategori',    fn($d) => $d->produk->kategori->nama_kategori ?? '-')
            ->editColumn('qty',      fn($d) => '<span class="badge badge-primary">'. $d->qty .'</span>')
            ->editColumn('harga',    fn($d) => 'Rp. '. format_uang($d->harga))
            ->editColumn('subtotal', fn($d) => '<strong>Rp. '. format_uang($d->subtotal) .'</strong>')
            ->rawColumns(['qty', 'subtotal'])
            ->make(true);
    }

    /**
     * Return JSON data for edit modal (AJAX)
     */
    public function getEditData(string $id)
    {
        $kunjungan = Kunjungan::with('toko')->findOrFail($id);

        return response()->json([
            'id'                    => $kunjungan->id,
            'toko_id'               => $kunjungan->toko_id,
            'tanggal_kunjungan_raw' => $kunjungan->tanggal_kunjungan->format('Y-m-d'),
            'catatan'               => $kunjungan->catatan,
            'foto_kunjungan'        => $kunjungan->foto_kunjungan,
            'foto_url'              => $kunjungan->foto_kunjungan
                ? asset('storage/kunjungan/' . $kunjungan->foto_kunjungan)
                : null,
        ]);
    }

    public function edit(string $id)
    {
        $kunjungan = Kunjungan::with('detail')->findOrFail($id);
        $toko      = Toko::orderBy('nama_toko')->get();
        $produk    = Produk::orderBy('nama_produk')->get();
        return view('kunjungan.edit', compact('kunjungan', 'toko', 'produk'));
    }

    public function update(Request $request, string $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        $request->validate([
            'toko_id'           => 'required|exists:tokos,id',
            'tanggal_kunjungan' => 'required|date',
            'catatan'           => 'nullable|string',
            'foto_kunjungan'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'toko_id'           => $request->toko_id,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'catatan'           => $request->catatan,
            ];

            if ($request->hasFile('foto_kunjungan')) {
                if ($kunjungan->foto_kunjungan && Storage::exists('public/kunjungan/' . $kunjungan->foto_kunjungan)) {
                    Storage::delete('public/kunjungan/' . $kunjungan->foto_kunjungan);
                }
                $file     = $request->file('foto_kunjungan');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/kunjungan', $filename);
                $data['foto_kunjungan'] = $filename;
            }

            $kunjungan->update($data);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Kunjungan berhasil diperbarui']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()], 422);
        }
    }

    public function destroy(string $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        DB::beginTransaction();
        try {
            foreach ($kunjungan->detail as $detail) {
                $produk = $detail->produk;
                $produk->stok += $detail->qty;
                $produk->save();
            }

            if ($kunjungan->foto_kunjungan && Storage::exists('public/kunjungan/' . $kunjungan->foto_kunjungan)) {
                Storage::delete('public/kunjungan/' . $kunjungan->foto_kunjungan);
            }

            $kunjungan->delete();
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Kunjungan berhasil dihapus dan stok dikembalikan']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()], 422);
        }
    }

    public function getProduk(string $id)
    {
        $produk = Produk::where('id_produk', $id)->with('kategori')->first();
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
        return response()->json($produk);
    }

    /**
     * Tambah produk ke kunjungan (AJAX dari modal edit).
     * ✅ MERGE: jika produk sudah ada di kunjungan, tambahkan qty-nya.
     */
    public function addProduk(Request $request)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'produk_id'    => 'required|integer',
            'qty'          => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $kunjungan = Kunjungan::findOrFail($request->kunjungan_id);
            $produk    = Produk::where('id_produk', $request->produk_id)->first();

            if (!$produk) {
                throw new \Exception("Produk tidak ditemukan");
            }
            if ($produk->stok < $request->qty) {
                throw new \Exception("Stok tidak mencukupi. Stok tersedia: {$produk->stok}");
            }

            // ✅ CEK apakah produk sudah ada di kunjungan ini
            $existingDetail = KunjunganDetail::where('kunjungan_id', $kunjungan->id)
                ->where('produk_id', $produk->id_produk)
                ->first();

            if ($existingDetail) {
                // ── MERGE: tambahkan qty ke baris yang sudah ada ──
                $tambahQty      = $request->qty;
                $tambahSubtotal = $produk->harga_jual * $tambahQty;

                $existingDetail->qty      += $tambahQty;
                $existingDetail->subtotal += $tambahSubtotal;
                $existingDetail->save();

                // Kurangi stok
                $produk->stok -= $tambahQty;
                $produk->save();

                // Update total kunjungan
                $kunjungan->total_qty   += $tambahQty;
                $kunjungan->total_nilai += $tambahSubtotal;
                $kunjungan->save();

                $message = "Qty produk \"{$produk->nama_produk}\" diperbarui menjadi {$existingDetail->qty}";

            } else {
                // ── BARU: buat baris detail baru ──
                $subtotal = $produk->harga_jual * $request->qty;

                KunjunganDetail::create([
                    'kunjungan_id' => $kunjungan->id,
                    'produk_id'    => $produk->id_produk,
                    'qty'          => $request->qty,
                    'harga'        => $produk->harga_jual,
                    'subtotal'     => $subtotal,
                ]);

                $produk->stok -= $request->qty;
                $produk->save();

                $kunjungan->total_qty   += $request->qty;
                $kunjungan->total_nilai += $subtotal;
                $kunjungan->save();

                $message = "Produk \"{$produk->nama_produk}\" berhasil ditambahkan";
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message,
                'merged'  => (bool) $existingDetail,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function deleteDetail(string $id)
    {
        DB::beginTransaction();
        try {
            $detail    = KunjunganDetail::findOrFail($id);
            $kunjungan = $detail->kunjungan;

            $produk = $detail->produk;
            $produk->stok += $detail->qty;
            $produk->save();

            $kunjungan->total_qty   -= $detail->qty;
            $kunjungan->total_nilai -= $detail->subtotal;
            $kunjungan->save();

            $detail->delete();
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Produk dihapus dan stok dikembalikan']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
