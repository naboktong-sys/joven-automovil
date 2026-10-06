<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Produk;

class LaporanStokExport implements FromCollection, WithHeadings, WithMapping
{
    protected $outletId;

    public function __construct($outletId = 'all')
    {
        $this->outletId = $outletId;
    }

    public function collection()
    {
        $query = Produk::with('kategori', 'outlet')
            ->orderBy('kode_produk');

        if ($this->outletId != 'all') {
            $query->where('id_outlet', $this->outletId);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode',
            'Nama Produk',
            'Kategori',
            'Outlet',
            'Harga Beli',
            'Harga Jual',
            'Stok',
        ];
    }

    public function map($produk): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $produk->kode_produk,
            $produk->nama_produk,
            $produk->kategori->nama_kategori ?? '-',
            $produk->outlet->nama_outlet ?? '-',
            $produk->harga_beli,
            $produk->harga_jual,
            $produk->stok,
        ];
    }
}
