<?php

namespace App\Exports;

use App\Http\Controllers\LaporanController;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Excel;
use App\Models\Outlet;

class LaporanPendapatanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents, Responsable
{
    use \Maatwebsite\Excel\Concerns\Exportable;

    private $awal;
    private $akhir;
    private $outletId;
    private $rawData;

    public $fileName;
    public $writerType = Excel::XLSX;

    public function __construct($awal, $akhir, $outletId = 'all')
    {
        $this->awal = $awal;
        $this->akhir = $akhir;
        $this->outletId = $outletId;

        $namaOutlet = $outletId === 'all' ? 'Semua-Outlet' : $this->getOutletName($outletId);

        $tanggal = date('Y-m-d', strtotime($akhir));
        $jam = date('His');

        $this->fileName = "Laporan-pendapatan-{$namaOutlet}-{$tanggal}-{$jam}.xlsx";
    }

    protected function getOutletName($outletId)
    {
        $outlet = Outlet::find($outletId);
        return $outlet ? str_replace(' ', '-', $outlet->nama_outlet) : 'Outlet-Tidak-Ditemukan';
    }

    public function collection()
    {
        $controller = new LaporanController();
        $data = $controller->getData($this->awal, $this->akhir, $this->outletId);

        // Simpan data mentah untuk perhitungan total
        $this->rawData = $data;

        // buang baris total terakhir kalau ada
        $last = end($data);
        if (isset($last['total_pengeluaran']) && $last['total_pengeluaran'] === 'Total Pendapatan') {
            array_pop($data);
        }

        // Kalau semua outlet
        if ($this->outletId === 'all') {
            $outlets = \App\Models\Outlet::where('status', 1)->get();

            return collect(array_map(function ($item) use ($outlets) {
                $row = [
                    'Tanggal' => $item['tanggal'] ?? '',
                ];

                foreach ($outlets as $outlet) {
                    $key = str_replace(' ', '_', strtolower($outlet->nama_outlet));
                    $nilai = isset($item[$key]) ? str_replace(',', '', $item[$key]) : 0;
                    $row[$outlet->nama_outlet] = $nilai === '' ? 0 : $nilai;
                }

                $row['Total Penjualan'] = isset($item['total_penjualan']) ? str_replace(',', '', $item['total_penjualan']) : 0;
                $row['Total Pembelian'] = isset($item['total_pembelian']) ? str_replace(',', '', $item['total_pembelian']) : 0;
                $row['Total Pengeluaran'] = isset($item['total_pengeluaran']) ? str_replace(',', '', $item['total_pengeluaran']) : 0;
                $row['Total Pendapatan'] = isset($item['total_pendapatan']) ? str_replace(',', '', $item['total_pendapatan']) : 0;
                $row['Total Laba'] = isset($item['total_laba']) ? str_replace(',', '', $item['total_laba']) : 0;

                return $row;
            }, $data));
        }

        // Kalau outlet tertentu
        return collect(array_map(function ($item) {
            return [
                'Tanggal' => $item['tanggal'] ?? '',
                'Penjualan'   => isset($item['total_penjualan']) ? str_replace(',', '', $item['total_penjualan']) : 0,
                'Pembelian'   => isset($item['total_pembelian']) ? str_replace(',', '', $item['total_pembelian']) : 0,
                'Pengeluaran' => isset($item['total_pengeluaran']) ? str_replace(',', '', $item['total_pengeluaran']) : 0,
                'Pendapatan'  => isset($item['total_pendapatan']) ? str_replace(',', '', $item['total_pendapatan']) : 0,
                'Laba'        => isset($item['total_laba']) ? str_replace(',', '', $item['total_laba']) : 0,
            ];
        }, $data));
    }

    public function headings(): array
    {
        if ($this->outletId === 'all') {
            $outlets = Outlet::where('status', 1)->pluck('nama_outlet')->toArray();
            return array_merge(
                ['Tanggal'],
                $outlets,
                ['Total Penjualan', 'Total Pembelian', 'Total Pengeluaran', 'Total Pendapatan', 'Total Laba']
            );
        }

        return ['Tanggal', 'Penjualan', 'Pembelian', 'Pengeluaran', 'Pendapatan', 'Laba'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk heading
            1 => [
                'font' => ['bold' => true, 'size' => 11],
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
                $dataCount = count($this->rawData);
                $lastRow = $dataCount + 2; // +1 heading, +1 untuk baris total

                if ($this->outletId === 'all') {
                    $outlets = Outlet::where('status', 1)->get();
                    $colCount = 1 + $outlets->count() + 5; // Tanggal + Outlets + 5 kolom total (termasuk Laba)
                    $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colCount);

                    // Hitung total untuk setiap outlet
                    $outletTotals = [];
                    foreach ($outlets as $outlet) {
                        $key = str_replace(' ', '_', strtolower($outlet->nama_outlet));
                        $total = 0;
                        foreach ($this->rawData as $row) {
                            $total += isset($row[$key]) ? (float)$row[$key] : 0;
                        }
                        $outletTotals[] = $total;
                    }

                    // Hitung grand totals
                    $grandTotalPenjualan = array_sum(array_column($this->rawData, 'total_penjualan'));
                    $grandTotalPembelian = array_sum(array_column($this->rawData, 'total_pembelian'));
                    $grandTotalPengeluaran = array_sum(array_column($this->rawData, 'total_pengeluaran'));
                    $grandTotalPendapatan = array_sum(array_column($this->rawData, 'total_pendapatan'));
                    $grandTotalLaba = array_sum(array_column($this->rawData, 'total_laba'));

                    // Set nilai total
                    $col = 1;
                    $sheet->setCellValueByColumnAndRow($col++, $lastRow, 'TOTAL');

                    foreach ($outletTotals as $total) {
                        $sheet->setCellValueByColumnAndRow($col++, $lastRow, $total);
                    }

                    $sheet->setCellValueByColumnAndRow($col++, $lastRow, $grandTotalPenjualan);
                    $sheet->setCellValueByColumnAndRow($col++, $lastRow, $grandTotalPembelian);
                    $sheet->setCellValueByColumnAndRow($col++, $lastRow, $grandTotalPengeluaran);
                    $sheet->setCellValueByColumnAndRow($col++, $lastRow, $grandTotalPendapatan);
                    $sheet->setCellValueByColumnAndRow($col++, $lastRow, $grandTotalLaba);

                } else {
                    // Outlet tertentu - 6 kolom (termasuk Laba)
                    $lastCol = 'F';

                    $totalPenjualan = array_sum(array_column($this->rawData, 'total_penjualan'));
                    $totalPembelian = array_sum(array_column($this->rawData, 'total_pembelian'));
                    $totalPengeluaran = array_sum(array_column($this->rawData, 'total_pengeluaran'));
                    $totalPendapatan = array_sum(array_column($this->rawData, 'total_pendapatan'));
                    $totalLaba = array_sum(array_column($this->rawData, 'total_laba'));

                    $sheet->setCellValue("A{$lastRow}", 'TOTAL');
                    $sheet->setCellValue("B{$lastRow}", $totalPenjualan);
                    $sheet->setCellValue("C{$lastRow}", $totalPembelian);
                    $sheet->setCellValue("D{$lastRow}", $totalPengeluaran);
                    $sheet->setCellValue("E{$lastRow}", $totalPendapatan);
                    $sheet->setCellValue("F{$lastRow}", $totalLaba);
                }

                // Style untuk baris total
                $sheet->getStyle("A{$lastRow}:{$lastCol}{$lastRow}")->applyFromArray([
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

                // Format angka untuk semua kolom kecuali tanggal
                $numericRange = $this->outletId === 'all' ? "B2:{$lastCol}{$lastRow}" : "B2:{$lastCol}{$lastRow}";
                $sheet->getStyle($numericRange)->getNumberFormat()->setFormatCode('#,##0');
            },
        ];
    }
}
