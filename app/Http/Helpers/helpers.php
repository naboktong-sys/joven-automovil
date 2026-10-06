<?php

/**
 * Helper Functions untuk Aplikasi Buku Kunjungan Sales
 */

if (! function_exists('format_uang')) {
    /**
     * Format angka menjadi format uang Indonesia
     *
     * @param  int|float  $angka
     * @return string
     */
    function format_uang($angka)
    {
        return number_format($angka, 0, ',', '.');
    }
}

if (! function_exists('tanggal_indonesia')) {
    /**
     * Format tanggal ke format Indonesia
     *
     * @param  string  $tanggal
     * @param  bool  $show_hari
     * @return string
     */
    function tanggal_indonesia($tanggal, $show_hari = true)
    {
        $nama_hari = [
            'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
        ];

        $nama_bulan = [
            '', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $tahun   = substr($tanggal, 0, 4);
        $bulan   = $nama_bulan[(int) substr($tanggal, 5, 2)];
        $tgl     = substr($tanggal, 8, 2);
        $text    = '';

        if ($show_hari) {
            $urutan_hari = date('w', strtotime($tanggal));
            $hari        = $nama_hari[$urutan_hari];
            $text       .= $hari . ', ';
        }

        $text .= $tgl . ' ' . $bulan . ' ' . $tahun;

        return $text;
    }
}

if (! function_exists('terbilang')) {
    /**
     * Konversi angka ke terbilang
     *
     * @param  int  $angka
     * @return string
     */
    function terbilang($angka)
    {
        $angka = abs($angka);
        $baca  = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        $terbilang = "";

        if ($angka < 12) {
            $terbilang = " " . $baca[$angka];
        } else if ($angka < 20) {
            $terbilang = terbilang($angka - 10) . " Belas";
        } else if ($angka < 100) {
            $terbilang = terbilang($angka / 10) . " Puluh" . terbilang($angka % 10);
        } else if ($angka < 200) {
            $terbilang = " Seratus" . terbilang($angka - 100);
        } else if ($angka < 1000) {
            $terbilang = terbilang($angka / 100) . " Ratus" . terbilang($angka % 100);
        } else if ($angka < 2000) {
            $terbilang = " Seribu" . terbilang($angka - 1000);
        } else if ($angka < 1000000) {
            $terbilang = terbilang($angka / 1000) . " Ribu" . terbilang($angka % 1000);
        } else if ($angka < 1000000000) {
            $terbilang = terbilang($angka / 1000000) . " Juta" . terbilang($angka % 1000000);
        } else if ($angka < 1000000000000) {
            $terbilang = terbilang($angka / 1000000000) . " Milyar" . terbilang(fmod($angka, 1000000000));
        } else if ($angka < 1000000000000000) {
            $terbilang = terbilang($angka / 1000000000000) . " Trilyun" . terbilang(fmod($angka, 1000000000000));
        }

        return trim($terbilang);
    }
}

if (! function_exists('tambah_nol_didepan')) {
    /**
     * Tambah nol di depan angka
     *
     * @param  int  $value
     * @param  int  $threshold
     * @return string
     */
    function tambah_nol_didepan($value, $threshold = null)
    {
        return sprintf("%0". $threshold ."s", $value);
    }
}

if (! function_exists('format_bytes')) {
    /**
     * Format bytes ke KB, MB, GB
     *
     * @param  int  $size
     * @param  int  $precision
     * @return string
     */
    function format_bytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }
}

if (! function_exists('calculate_distance')) {
    /**
     * Hitung jarak antara 2 koordinat GPS (dalam km)
     * Menggunakan formula Haversine
     *
     * @param  float  $lat1
     * @param  float  $lon1
     * @param  float  $lat2
     * @param  float  $lon2
     * @return float
     */
    function calculate_distance($lat1, $lon1, $lat2, $lon2)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $kilometers = $miles * 1.609344;

        return round($kilometers, 2);
    }
}

if (! function_exists('get_bulan_options')) {
    /**
     * Get array bulan untuk select option
     *
     * @return array
     */
    function get_bulan_options()
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }
}

if (! function_exists('nama_bulan')) {
    /**
     * Get nama bulan dari nomor bulan
     *
     * @param  int  $bulan
     * @return string
     */
    function nama_bulan($bulan)
    {
        $nama_bulan = get_bulan_options();
        return $nama_bulan[$bulan] ?? '';
    }
}

if (! function_exists('alert_stok_menipis')) {
    /**
     * Check apakah stok produk menipis
     *
     * @param  int  $stok
     * @param  int  $minimum_stok
     * @return bool
     */
    function alert_stok_menipis($stok, $minimum_stok = 10)
    {
        return $stok <= $minimum_stok;
    }
}

if (! function_exists('get_foto_url')) {
    /**
     * Get URL foto dengan fallback
     *
     * @param  string  $path
     * @param  string  $filename
     * @param  string  $default
     * @return string
     */
    function get_foto_url($path, $filename, $default = 'default.png')
    {
        if ($filename && \Storage::exists("public/{$path}/{$filename}")) {
            return asset("storage/{$path}/{$filename}");
        }
        return asset("img/{$default}");
    }
}
