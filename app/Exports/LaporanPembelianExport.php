<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Pembelian;

class LaporanPembelianExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tanggalAwal;
    protected $tanggalAkhir;
    protected $outletId;

    public function __construct($awal, $akhir, $outletId = 'all')
    {
        $this->tanggalAwal = $awal;
        $this->tanggalAkhir = $akhir;
        $this->outletId = $outletId;
    }

    public function collection()
    {
        $query = Pembelian::with('supplier', 'outlet')
            ->whereDate('created_at', '>=', $this->tanggalAwal)
            ->whereDate('created_at', '<=', $this->tanggalAkhir);

        if ($this->outletId != 'all') {
            $query->where('id_outlet', $this->outletId);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Supplier',
            'Outlet',
            'Total Item',
            'Total Harga',
            'Diskon',
            'Grand Total',
        ];
    }

    public function map($pembelian): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            tanggal_indonesia($pembelian->created_at, false),
            $pembelian->supplier->nama ?? '-',
            $pembelian->outlet->nama_outlet ?? '-',
            $pembelian->total_item,
            $pembelian->total_harga,
            $pembelian->diskon,
            $pembelian->bayar,
        ];
    }
}
