<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use App\Models\Penjualan;

class LaporanPenjualanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $tanggalAwal;
    protected $tanggalAkhir;
    protected $outletId;
    protected $data;

    public function __construct($awal, $akhir, $outletId = 'all')
    {
        $this->tanggalAwal = $awal;
        $this->tanggalAkhir = $akhir;
        $this->outletId = $outletId;
    }

    public function collection()
    {
        $query = Penjualan::with('outlet')
            ->whereDate('created_at', '>=', $this->tanggalAwal)
            ->whereDate('created_at', '<=', $this->tanggalAkhir)
            ->where('total_item', '>', 0);

        if ($this->outletId != 'all') {
            $query->where('id_outlet', $this->outletId);
        }

        $this->data = $query->get();
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Outlet',
            'Kode Member',
            'Total Item',
            'Total Harga',
            'Diskon',
            'Total Bayar',
        ];
    }

    public function map($penjualan): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            tanggal_indonesia($penjualan->created_at, false),
            $penjualan->outlet->nama_outlet ?? '-',
            $penjualan->kode_member ?? '-',
            $penjualan->total_item,
            $penjualan->total_harga,
            $penjualan->diskon,
            $penjualan->bayar,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk heading
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2EFDA']
                ]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $this->data->count() + 2; // +1 heading, +1 untuk baris total baru

                // Hitung total
                $totalItem = $this->data->sum('total_item');
                $totalHarga = $this->data->sum('total_harga');
                $totalDiskon = $this->data->sum('diskon');
                $totalBayar = $this->data->sum('bayar');

                // Tambahkan baris total
                $sheet->setCellValue("A{$lastRow}", '');
                $sheet->setCellValue("B{$lastRow}", '');
                $sheet->setCellValue("C{$lastRow}", '');
                $sheet->setCellValue("D{$lastRow}", 'TOTAL');
                $sheet->setCellValue("E{$lastRow}", $totalItem);
                $sheet->setCellValue("F{$lastRow}", $totalHarga);
                $sheet->setCellValue("G{$lastRow}", $totalDiskon);
                $sheet->setCellValue("H{$lastRow}", $totalBayar);

                // Style untuk baris total
                $sheet->getStyle("A{$lastRow}:H{$lastRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFF2CC']
                    ],
                    'borders' => [
                        'top' => [
                            'borderStyle' => Border::BORDER_DOUBLE,
                        ]
                    ]
                ]);

                // Format angka untuk kolom E-H (Total Item, Total Harga, Diskon, Total Bayar)
                $sheet->getStyle("E2:H{$lastRow}")->getNumberFormat()
                    ->setFormatCode('#,##0');

                // Auto size kolom
                foreach(range('A','H') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
