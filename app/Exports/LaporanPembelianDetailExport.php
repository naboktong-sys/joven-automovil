<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\PembelianDetail;

class LaporanPembelianDetailExport implements FromCollection, WithHeadings, WithMapping
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
        $query = PembelianDetail::with(['produk', 'produk.kategori', 'pembelian'])
            ->whereHas('pembelian', function($q) {
                $q->whereDate('created_at', '>=', $this->tanggalAwal)
                  ->whereDate('created_at', '<=', $this->tanggalAkhir);

                if ($this->outletId != 'all') {
                    $q->where('id_outlet', $this->outletId);
                }
            })
            ->orderBy('id_pembelian_detail', 'desc');

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Produk',
            'Nama Produk',
            'Kategori',
            'Harga Beli',
            'Jumlah',
            'Subtotal',
        ];
    }

    public function map($detail): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $detail->produk->kode_produk ?? '-',
            $detail->produk->nama_produk ?? '-',
            $detail->produk->kategori->nama_kategori ?? '-',
            $detail->harga_beli ?? 0,
            $detail->jumlah,
            ($detail->harga_beli ?? 0) * $detail->jumlah,
        ];
    }
}
