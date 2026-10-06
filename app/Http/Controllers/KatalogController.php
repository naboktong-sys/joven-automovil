<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    /**
     * Display katalog produk
     */
    public function index()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('katalog.index', compact('kategori'));
    }

    /**
     * Get data produk for katalog
     */
    public function data()
    {
        $produk = Produk::with('kategori')
            ->orderBy('nama_produk')
            ->get()
            ->map(function($item) {
                return [
                    'id_produk' => $item->id_produk,
                    'kode_produk' => $item->kode_produk,
                    'nama_produk' => $item->nama_produk,
                    'kategori' => $item->kategori->nama_kategori ?? '-',
                    'id_kategori' => $item->id_kategori,
                    'merk' => $item->merk,
                    'harga_jual' => $item->harga_jual,
                    'diskon' => $item->diskon ?? 0,
                    'stok' => $item->stok,
                    'gambar_url' => $item->gambar_url,
                ];
            });

        return response()->json($produk);
    }

    /**
     * Get detail produk
     */
    public function detail($id)
    {
        $produk = Produk::with('kategori')->where('id_produk', $id)->firstOrFail();

        return response()->json([
            'id_produk' => $produk->id_produk,
            'kode_produk' => $produk->kode_produk,
            'nama_produk' => $produk->nama_produk,
            'kategori' => $produk->kategori->nama_kategori ?? '-',
            'merk' => $produk->merk,
            'harga_beli' => $produk->harga_beli,
            'harga_jual' => $produk->harga_jual,
            'diskon' => $produk->diskon ?? 0,
            'stok' => $produk->stok,
            'gambar_url' => $produk->gambar_url,
        ]);
    }

    /**
     * Search produk (optional - untuk autocomplete)
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $produk = Produk::with('kategori')
            ->where('nama_produk', 'LIKE', "%{$query}%")
            ->orWhere('kode_produk', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id_produk,
                    'text' => $item->nama_produk,
                    'kode' => $item->kode_produk,
                    'harga' => $item->harga_jual,
                    'stok' => $item->stok,
                ];
            });

        return response()->json($produk);
    }
}
