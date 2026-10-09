<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * Export histori kunjungan sales (satu baris per produk per kunjungan).
 */
class HistoriTokoExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $kunjungan;
    protected $no = 0;

    public function __construct($kunjungan)
    {
        $this->kunjungan = $kunjungan;
    }

    public function collection()
    {
        $rows = new Collection();

        foreach ($this->kunjungan as $kunjungan) {
            if ($kunjungan->detail->isEmpty()) {
                $rows->push(['kunjungan' => $kunjungan, 'detail' => null]);
                continue;
            }

            foreach ($kunjungan->detail as $detail) {
                $rows->push(['kunjungan' => $kunjungan, 'detail' => $detail]);
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Toko',
            'Alamat',
            'Kode Produk',
            'Nama Produk',
            'Qty',
            'Harga',
            'Subtotal',
            'Catatan',
        ];
    }

    public function map($row): array
    {
        $kunjungan = $row['kunjungan'];
        $detail = $row['detail'];
        $this->no++;

        return [
            $this->no,
            $kunjungan->tanggal_kunjungan->format('d-m-Y'),
            $kunjungan->toko->nama_toko ?? '-',
            $kunjungan->toko->alamat ?? '-',
            $detail->produk->kode_produk ?? '-',
            $detail ? ($detail->produk->nama_produk ?? '(produk dihapus)') : '-',
            $detail->qty ?? 0,
            $detail->harga ?? 0,
            $detail->subtotal ?? 0,
            $kunjungan->catatan,
        ];
    }
}
