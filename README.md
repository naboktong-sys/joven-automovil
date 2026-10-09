# Buku Kunjungan Sales Onderdil

Aplikasi web (Laravel 8 + AdminLTE 2) untuk mencatat kunjungan sales ke toko langganan, produk onderdil yang dibeli, serta histori pembelian per toko.

## Fitur

- **Master data:** Kategori, Produk (gambar, barcode, stok), Katalog Produk, Toko Langganan (foto, GPS, kontak)
- **Kunjungan sales:** catat kunjungan + produk yang dibeli (stok otomatis berkurang, dikembalikan saat kunjungan/item dihapus), edit lewat modal
- **Histori toko:** riwayat per toko dan seluruh toko, filter toko/tanggal, ekspor Excel & PDF
- **Pengaturan & user:** profil perusahaan/logo, manajemen user (khusus admin)

## Level user

| Level | Peran | Akses |
|-------|-------|-------|
| 1 | Admin | Semua fitur, termasuk Manajemen User & Pengaturan |
| 2 | Sales | Semua fitur kecuali Manajemen User & Pengaturan |

Akun dibuat oleh admin lewat menu **Manajemen User**. Registrasi publik dimatikan.

## Menjalankan lokal

```bash
composer install
cp .env.example .env
php artisan key:generate
# isi DB_* di .env (MySQL), lalu:
php artisan migrate --seed   # seed membuat admin awal & setting default
php artisan storage:link
php artisan serve
```

Seeder membuat `admin@gmail.com` dengan password `123` — **segera ganti** setelah login pertama.

Untuk memakai data yang sudah ada, impor dump SQL ke database MySQL lalu lewati `migrate --seed` (tabel `migrations` sudah terisi di dump).

## Catatan teknis

- Frontend memakai AdminLTE 2 / Bootstrap 3 dari `public/AdminLTE-2`, tidak perlu `npm build`.
- Upload foto toko, kunjungan, dan produk disimpan di `storage/app/public` (butuh `storage:link`); logo & foto user di `public/img`.
- Sesi disimpan di database (`SESSION_DRIVER=database`).
- Autentikasi memakai Fortify (login/logout saja); fitur Jetstream lain dimatikan.
