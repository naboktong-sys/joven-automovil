<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use PDF;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of produk
     */
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');

        return view('produk.index', compact('kategori'));
    }

    /**
     * Get data for DataTables
     */
    public function data()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
            ->select('produk.*', 'nama_kategori')
            ->orderBy('kode_produk', 'asc')
            ->get();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '<input type="checkbox" name="id_produk[]" value="'. $produk->id_produk .'">';
            })
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="label label-success">'. $produk->kode_produk .'</span>';
            })
            ->addColumn('gambar', function ($produk) {
                if ($produk->gambar) {
                    return '<img src="'. $produk->gambar_url .'" alt="'. $produk->nama_produk .'" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 2px solid #ecf0f1;">';
                }
                return '<div style="width: 50px; height: 50px; background: #ecf0f1; border-radius: 8px; display: flex; align-items: center; justify-content: center;"><i class="fa fa-image" style="color: #bdc3c7;"></i></div>';
            })
            ->addColumn('harga_beli', function ($produk) {
                return format_uang($produk->harga_beli);
            })
            ->addColumn('harga_jual', function ($produk) {
                return format_uang($produk->harga_jual);
            })
            ->addColumn('stok', function ($produk) {
                $badge = $produk->stok <= 10 ? 'label-danger' : 'label-success';
                return '<span class="label '. $badge .'">'. format_uang($produk->stok) .'</span>';
            })
            ->addColumn('aksi', function ($produk) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('produk.update', $produk->id_produk) .'`)" class="btn btn-xs btn-info btn-flat">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button type="button" onclick="deleteData(`'. route('produk.destroy', $produk->id_produk) .'`)" class="btn btn-xs btn-danger btn-flat">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk', 'select_all', 'gambar', 'stok'])
            ->make(true);
    }

    /**
     * Store a newly created produk
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:produk,nama_produk',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0|max:100',
            'merk' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_produk.required' => 'Nama produk harus diisi',
            'nama_produk.unique' => 'Produk dengan nama ini sudah ada',
            'id_kategori.required' => 'Kategori harus dipilih',
            'harga_beli.required' => 'Harga beli harus diisi',
            'harga_jual.required' => 'Harga jual harus diisi',
            'stok.required' => 'Stok harus diisi',
        ]);

        try {
            $lastId = Produk::max('id_produk') ?? 0;

            $data = [
                'kode_produk' => 'P' . tambah_nol_didepan($lastId + 1, 6),
                'nama_produk' => $request->nama_produk,
                'id_kategori' => $request->id_kategori,
                'merk' => $request->merk,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'stok' => $request->stok,
                'diskon' => $request->diskon ?? 0,
            ];

            // Handle upload gambar
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('produk', $filename, 'public');
                $data['gambar'] = $path;
            }

            Produk::create($data);

            return response()->json('Data berhasil disimpan', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified produk
     */
    public function show($id)
    {
        $produk = Produk::find($id);

        if ($produk) {
            $produk->gambar_url = $produk->gambar_url;
        }

        return response()->json($produk);
    }

    /**
     * Update the specified produk
     */
    public function update(Request $request, $id)
    {
        try {
            $produk = Produk::find($id);

            if (!$produk) {
                return response()->json(['message' => 'Produk tidak ditemukan'], 404);
            }

            $request->validate([
                'nama_produk' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('produk', 'nama_produk')->ignore($id, 'id_produk')
                ],
                'id_kategori' => 'required|exists:kategori,id_kategori',
                'harga_beli' => 'required|numeric|min:0',
                'harga_jual' => 'required|numeric|min:0',
                'stok' => 'required|numeric|min:0',
                'diskon' => 'nullable|numeric|min:0|max:100',
                'merk' => 'nullable|string|max:100',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ], [
                'nama_produk.required' => 'Nama produk harus diisi',
                'nama_produk.unique' => 'Produk dengan nama ini sudah ada',
                'id_kategori.required' => 'Kategori harus dipilih',
            ]);

            $data = [
                'nama_produk' => $request->nama_produk,
                'id_kategori' => $request->id_kategori,
                'merk' => $request->merk,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'diskon' => $request->diskon ?? 0,
                'stok' => $request->stok ?? 0,
            ];

            // Handle upload gambar baru
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                    Storage::disk('public')->delete($produk->gambar);
                }

                $file = $request->file('gambar');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('produk', $filename, 'public');
                $data['gambar'] = $path;
            }

            $produk->update($data);

            return response()->json('Data berhasil disimpan', 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Product update error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified produk
     */
    public function destroy($id)
    {
        try {
            $produk = Produk::find($id);

            if (!$produk) {
                return response()->json(['message' => 'Produk tidak ditemukan'], 404);
            }

            // Check if produk has kunjungan details
            if ($produk->kunjunganDetail()->count() > 0) {
                return response()->json([
                    'message' => 'Produk tidak dapat dihapus karena sudah ada histori kunjungan'
                ], 422);
            }

            // Delete gambar if exists
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $produk->delete();

            return response(null, 204);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete selected produk
     */
    public function deleteSelected(Request $request)
    {
        try {
            $deleted = 0;
            $failed = 0;

            foreach ($request->id_produk as $id) {
                $produk = Produk::find($id);

                if ($produk) {
                    // Check if has kunjungan
                    if ($produk->kunjunganDetail()->count() > 0) {
                        $failed++;
                        continue;
                    }

                    // Delete gambar
                    if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                        Storage::disk('public')->delete($produk->gambar);
                    }

                    $produk->delete();
                    $deleted++;
                }
            }

            if ($failed > 0) {
                return response()->json([
                    'message' => "{$deleted} produk berhasil dihapus, {$failed} produk gagal karena memiliki histori kunjungan"
                ], 200);
            }

            return response(null, 204);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cetak barcode produk
     */
    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();

        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            if ($produk) {
                $dataproduk[] = $produk;
            }
        }

        $no = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('barcode-produk-' . date('YmdHis') . '.pdf');
    }

    /**
     * Get produk dengan stok menipis
     */
    public function stokMenipis()
    {
        $produk = Produk::with('kategori')
            ->where('stok', '<=', 10)
            ->orderBy('stok', 'ASC')
            ->get();

        return view('produk.stok_menipis', compact('produk'));
    }
}
