<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Pengeluaran;

class LaporanPengeluaranExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tanggalAwal;
    protected $tanggalAkhir;

    public function __construct($awal, $akhir)
    {
        $this->tanggalAwal = $awal;
        $this->tanggalAkhir = $akhir;
    }

    public function collection()
    {
        return Pengeluaran::whereDate('created_at', '>=', $this->tanggalAwal)
            ->whereDate('created_at', '<=', $this->tanggalAkhir)
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Deskripsi',
            'Nominal',
        ];
    }

    public function map($pengeluaran): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            tanggal_indonesia($pengeluaran->created_at, false),
            $pengeluaran->deskripsi,
            $pengeluaran->nominal,
        ];
    }
}
