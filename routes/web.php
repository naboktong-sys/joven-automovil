<?php

use App\Http\Controllers\{
    DashboardController,
    KategoriController,
    ProdukController,
    SettingController,
    UserController,
    TokoController,
    KunjunganController,
    HistoriTokoController,
    KatalogController,
};
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes - Aplikasi Buku Kunjungan Sales Onderdil
|--------------------------------------------------------------------------
| Route untuk aplikasi sales yang mencatat kunjungan ke toko langganan
| dan histori pembelian produk onderdil per toko
|--------------------------------------------------------------------------
*/

// ============================================
// UTILITY ROUTES (Development/Deployment)
// ============================================
Route::get('/optimize-app', function () {
    Artisan::call('optimize');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    return 'Optimize berhasil!';
});

Route::get('/deploy-tools', function () {
    Artisan::call('migrate', ['--force' => true]);
    Artisan::call('db:seed', ['--force' => true]);
    Artisan::call('optimize');
    return 'Deploy tools executed!';
});

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ============================================
// AUTHENTICATED ROUTES (Sales User)
// ============================================
Route::group(['middleware' => 'auth'], function () {

    // --------------------------------------------
    // DASHBOARD
    // --------------------------------------------
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --------------------------------------------
    // PRODUK & KATEGORI (Master Data)
    // --------------------------------------------
    // Kategori Produk
    Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    Route::resource('/kategori', KategoriController::class);

    // Produk Onderdil
    Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
    Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
    Route::post('/produk/cetak-barcode', [ProdukController::class, 'cetakBarcode'])->name('produk.cetak_barcode');
    Route::get('/produk/stok-menipis', [ProdukController::class, 'stokMenipis'])->name('produk.stok_menipis');
    Route::resource('/produk', ProdukController::class); // ✅ DITAMBAHKAN!

    // --------------------------------------------
    // KATALOG PRODUK
    // --------------------------------------------
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
    Route::get('/katalog/data', [KatalogController::class, 'data'])->name('katalog.data');
    Route::get('/katalog/detail/{id}', [KatalogController::class, 'detail'])->name('katalog.detail');
    Route::get('/katalog/search', [KatalogController::class, 'search'])->name('katalog.search');

    // --------------------------------------------
    // TOKO LANGGANAN
    // --------------------------------------------
    Route::get('/toko/data', [TokoController::class, 'data'])->name('toko.data');
    Route::get('/toko/{id}/histori', [HistoriTokoController::class, 'show'])->name('toko.histori');
    Route::get('/toko/{id}/histori/data', [HistoriTokoController::class, 'data'])->name('toko.histori.data');
    Route::resource('/toko', TokoController::class);

    // --------------------------------------------
    // KUNJUNGAN SALES (Fitur Utama)
    // --------------------------------------------
    // List semua kunjungan
    Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.index');
    Route::get('/kunjungan/data', [KunjunganController::class, 'data'])->name('kunjungan.data');

    // Tambah kunjungan baru
    Route::get('/kunjungan/create', [KunjunganController::class, 'create'])->name('kunjungan.create');
    Route::post('/kunjungan', [KunjunganController::class, 'store'])->name('kunjungan.store');

    // Detail kunjungan
    Route::get('/kunjungan/{id}', [KunjunganController::class, 'show'])->name('kunjungan.show');
    Route::get('/kunjungan/{id}/detail/data', [KunjunganController::class, 'detailData'])->name('kunjungan.detail.data');

    // Edit & Delete kunjungan
    Route::get('/kunjungan/{id}/edit', [KunjunganController::class, 'edit'])->name('kunjungan.edit');
    Route::put('/kunjungan/{id}', [KunjunganController::class, 'update'])->name('kunjungan.update');
    Route::delete('/kunjungan/{id}', [KunjunganController::class, 'destroy'])->name('kunjungan.destroy');

    // AJAX endpoints untuk proses kunjungan
    Route::post('/kunjungan/add-produk', [KunjunganController::class, 'addProduk'])->name('kunjungan.add_produk');
    Route::delete('/kunjungan/detail/{id}', [KunjunganController::class, 'deleteDetail'])->name('kunjungan.delete_detail');
    Route::get('/kunjungan/get-produk/{id}', [KunjunganController::class, 'getProduk'])->name('kunjungan.get_produk');

     Route::get('kunjungan/{id}/edit-data', [KunjunganController::class, 'getEditData'])->name('kunjungan.edit.data');

    // --------------------------------------------
    // HISTORI KUNJUNGAN (Laporan Sederhana)
    // --------------------------------------------
    // Histori semua toko
    Route::get('/histori', [HistoriTokoController::class, 'index'])->name('histori.index');
    Route::get('/histori/data', [HistoriTokoController::class, 'dataAll'])->name('histori.data');

    // Filter histori
    Route::get('/histori/filter', [HistoriTokoController::class, 'filter'])->name('histori.filter');

    // Export histori
    Route::get('/histori/export/excel', [HistoriTokoController::class, 'exportExcel'])->name('histori.export_excel');
    Route::get('/histori/export/pdf', [HistoriTokoController::class, 'exportPdf'])->name('histori.export_pdf');

    // --------------------------------------------
    // PROFIL SALES
    // --------------------------------------------
    Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
    Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');
    Route::post('/profil/password', [UserController::class, 'updatePassword'])->name('user.update_password');
    Route::post('/profil/foto', [UserController::class, 'updateFoto'])->name('user.update_foto');

    // --------------------------------------------
    // PENGATURAN APLIKASI
    // --------------------------------------------
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');

    // --------------------------------------------
    // USER MANAGEMENT (Opsional - jika multi user)
    // --------------------------------------------
    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::resource('/user', UserController::class);

});
