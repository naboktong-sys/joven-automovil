<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // BARU - Untuk kasir, cek outlet session
        if (auth()->user()->level == 2) {
            if (!session()->has('id_outlet')) {
                $outlets = auth()->user()->getAccessibleOutlets();

                // Auto-select jika hanya 1 outlet
                if ($outlets->count() == 1) {
                    session()->put('id_outlet', $outlets->first()->id_outlet);
                    session()->save();
                } else {
                    return redirect()->route('outlet.select');
                }
            }

            return view('kasir.dashboard');
        }

        // Admin dashboard
        $kategori = Kategori::count();
        $produk = Produk::count();
        $toko = Toko::count();

        return view('admin.dashboard', compact('kategori', 'produk', 'toko'));
    }
}
