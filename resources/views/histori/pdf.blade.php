<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Histori Kunjungan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #222; }
        h2 { margin: 0 0 4px 0; }
        .meta { margin-bottom: 12px; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 4px 6px; vertical-align: top; }
        th { background: #e8f4f2; text-align: left; }
        .right { text-align: right; }
        .center { text-align: center; }
        tfoot td { font-weight: bold; background: #f5f5f5; }
    </style>
</head>
<body>
    <h2>Histori Kunjungan Sales</h2>
    <div class="meta">
        Toko: {{ $toko->nama_toko ?? 'Semua Toko' }}<br>
        Periode:
        {{ $tanggal_awal ? tanggal_indonesia($tanggal_awal, false) : 'Awal' }}
        s/d
        {{ $tanggal_akhir ? tanggal_indonesia($tanggal_akhir, false) : 'Sekarang' }}<br>
        Dicetak: {{ date('d-m-Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%" class="center">No</th>
                <th width="11%">Tanggal</th>
                <th width="18%">Toko</th>
                <th>Produk</th>
                <th width="7%" class="center">Qty</th>
                <th width="13%" class="right">Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kunjungan as $k)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ tanggal_indonesia($k->tanggal_kunjungan->format('Y-m-d'), false) }}</td>
                    <td>{{ $k->toko->nama_toko ?? '-' }}</td>
                    <td>
                        @foreach($k->detail as $d)
                            {{ $d->produk->nama_produk ?? '(produk dihapus)' }} ({{ $d->qty }}x)@if(!$loop->last), @endif
                        @endforeach
                    </td>
                    <td class="center">{{ $k->total_qty }}</td>
                    <td class="right">Rp. {{ format_uang($k->total_nilai) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="right">TOTAL</td>
                <td class="center">{{ $totalQty }}</td>
                <td class="right">Rp. {{ format_uang($totalNilai) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
