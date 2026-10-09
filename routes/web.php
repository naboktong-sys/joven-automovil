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

/*
|--------------------------------------------------------------------------
| Web Routes - Aplikasi Buku Kunjungan Sales Onderdil
|--------------------------------------------------------------------------
| Route untuk aplikasi sales yang mencatat kunjungan ke toko langganan
| dan histori pembelian produk onderdil per toko.
|
| Level user: 1 = Admin, 2 = Sales
|--------------------------------------------------------------------------
*/

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ============================================
// AUTHENTICATED ROUTES
// ============================================
Route::group(['middleware' => 'auth'], function () {

    // --------------------------------------------
    // DASHBOARD
    // --------------------------------------------
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --------------------------------------------
    // PRODUK & KATEGORI (Master Data)
    // --------------------------------------------
    Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    Route::resource('/kategori', KategoriController::class)->except(['create', 'edit']);

    Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
    Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
    Route::post('/produk/cetak-barcode', [ProdukController::class, 'cetakBarcode'])->name('produk.cetak_barcode');
    Route::resource('/produk', ProdukController::class)->except(['create', 'edit']);

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
    Route::resource('/toko', TokoController::class)->except(['create', 'edit']);

    // --------------------------------------------
    // KUNJUNGAN SALES (Fitur Utama)
    // --------------------------------------------
    Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.index');
    Route::get('/kunjungan/data', [KunjunganController::class, 'data'])->name('kunjungan.data');

    Route::get('/kunjungan/create', [KunjunganController::class, 'create'])->name('kunjungan.create');
    Route::post('/kunjungan', [KunjunganController::class, 'store'])->name('kunjungan.store');

    // AJAX endpoints (didaftarkan sebelum route {id} agar tidak bentrok)
    Route::post('/kunjungan/add-produk', [KunjunganController::class, 'addProduk'])->name('kunjungan.add_produk');
    Route::delete('/kunjungan/detail/{id}', [KunjunganController::class, 'deleteDetail'])->name('kunjungan.delete_detail');
    Route::get('/kunjungan/get-produk/{id}', [KunjunganController::class, 'getProduk'])->name('kunjungan.get_produk');

    Route::get('/kunjungan/{id}', [KunjunganController::class, 'show'])->name('kunjungan.show');
    Route::get('/kunjungan/{id}/detail/data', [KunjunganController::class, 'detailData'])->name('kunjungan.detail.data');
    Route::get('/kunjungan/{id}/edit-data', [KunjunganController::class, 'getEditData'])->name('kunjungan.edit.data');
    Route::get('/kunjungan/{id}/edit', [KunjunganController::class, 'edit'])->name('kunjungan.edit');
    Route::put('/kunjungan/{id}', [KunjunganController::class, 'update'])->name('kunjungan.update');
    Route::delete('/kunjungan/{id}', [KunjunganController::class, 'destroy'])->name('kunjungan.destroy');

    // --------------------------------------------
    // HISTORI KUNJUNGAN
    // --------------------------------------------
    Route::get('/histori', [HistoriTokoController::class, 'index'])->name('histori.index');
    Route::get('/histori/data', [HistoriTokoController::class, 'dataAll'])->name('histori.data');
    Route::get('/histori/export/excel', [HistoriTokoController::class, 'exportExcel'])->name('histori.export_excel');
    Route::get('/histori/export/pdf', [HistoriTokoController::class, 'exportPdf'])->name('histori.export_pdf');

    // --------------------------------------------
    // PROFIL (semua user yang login)
    // --------------------------------------------
    Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
    Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');

    // --------------------------------------------
    // KHUSUS ADMIN (level 1): Pengaturan & Manajemen User
    // --------------------------------------------
    Route::group(['middleware' => 'level:1'], function () {
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
        Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');

        Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
        Route::resource('/user', UserController::class)->except(['create', 'edit']);
    });

});
