<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Toko;

class DashboardController extends Controller
{
    public function index()
    {
        $kategori = Kategori::count();
        $produk = Produk::count();
        $toko = Toko::count();

        return view('admin.dashboard', compact('kategori', 'produk', 'toko'));
    }
}
