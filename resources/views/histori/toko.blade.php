@extends('layouts.master')

@section('title')
    Histori {{ $toko->nama_toko }}
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('toko.index') }}">Toko Langganan</a></li>
    <li class="active">Histori {{ $toko->nama_toko }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box modern-box">
            <div class="box-header">
                <div class="box-header-left">
                    <h3 class="box-title">
                        <i class="fa fa-building"></i>
                        <span>{{ $toko->nama_toko }}</span>
                    </h3>
                    <p class="box-subtitle">
                        {{ $toko->alamat }}
                        @if($toko->kontak) &middot; {{ $toko->kontak }} @endif
                    </p>
                </div>
                <div class="box-header-right">
                    <a href="{{ route('toko.index') }}" class="btn btn-default btn-action">
                        <i class="fa fa-arrow-left"></i> <span>Kembali</span>
                    </a>
                    <button type="button" onclick="exportData('{{ route('histori.export_excel') }}')" class="btn btn-success btn-action">
                        <i class="fa fa-file-excel-o"></i> <span>Excel</span>
                    </button>
                    <button type="button" onclick="exportData('{{ route('histori.export_pdf') }}')" class="btn btn-danger btn-action">
                        <i class="fa fa-file-pdf-o"></i> <span>PDF</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Ringkasan --}}
<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-calendar-check-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Kunjungan</span>
                <span class="info-box-number">{{ $totalKunjungan }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Belanja</span>
                <span class="info-box-number">Rp. {{ format_uang($totalBelanja) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-line-chart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Rata-rata / Kunjungan</span>
                <span class="info-box-number">Rp. {{ format_uang($rataRataBelanja) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-clock-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Kunjungan Terakhir</span>
                <span class="info-box-number" style="font-size: 15px;">
                    {{ $kunjunganTerakhir ? tanggal_indonesia($kunjunganTerakhir->tanggal_kunjungan->format('Y-m-d'), false) : '-' }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Produk sering dibeli --}}
    <div class="col-lg-4">
        <div class="box modern-box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-star"></i> Produk Paling Sering Dibeli</h3>
            </div>
            <div class="box-body">
                @forelse($produkSering as $p)
                    <div style="padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                        <strong>{{ $p->nama_produk }}</strong>
                        <div class="text-muted" style="font-size: 12px;">
                            {{ $p->kode_produk }} @if($p->merk) &middot; {{ $p->merk }} @endif
                        </div>
                        <span class="label label-success">{{ $p->total_qty }} pcs</span>
                        <span class="label label-info">Rp. {{ format_uang($p->total_nilai) }}</span>
                    </div>
                @empty
                    <p class="text-muted">Belum ada produk yang dibeli.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Riwayat --}}
    <div class="col-lg-8">
        <div class="box modern-box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-history"></i> Riwayat Kunjungan</h3>
            </div>
            <div class="box-body">
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-4">
                        <input type="date" id="filter_tanggal_awal" class="form-control" title="Tanggal awal">
                    </div>
                    <div class="col-md-4">
                        <input type="date" id="filter_tanggal_akhir" class="form-control" title="Tanggal akhir">
                    </div>
                    <div class="col-md-4">
                        <button type="button" onclick="filterData()" class="btn btn-info"><i class="fa fa-filter"></i> Filter</button>
                        <button type="button" onclick="resetFilter()" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</button>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table id="table-histori-toko" class="table table-modern table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="16%">Tanggal</th>
                                <th>Produk</th>
                                <th width="12%">Qty</th>
                                <th width="18%">Total Nilai</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let table;

    function filterParams() {
        return {
            tanggal_awal: $('#filter_tanggal_awal').val(),
            tanggal_akhir: $('#filter_tanggal_akhir').val()
        };
    }

    $(function () {
        table = $('#table-histori-toko').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('toko.histori.data', $toko->id) }}',
                data: function (d) {
                    $.extend(d, filterParams());
                }
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal_kunjungan'},
                {data: 'detail_produk', searchable: false, sortable: false},
                {data: 'total_qty'},
                {data: 'total_nilai'},
                {data: 'aksi', searchable: false, sortable: false}
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Tidak ada histori yang ditemukan",
                emptyTable: "Toko ini belum pernah dikunjungi",
                paginate: {next: '&raquo;', previous: '&laquo;'}
            }
        });
    });

    function filterData() {
        table.ajax.reload();
    }

    function resetFilter() {
        $('#filter_tanggal_awal').val('');
        $('#filter_tanggal_akhir').val('');
        table.ajax.reload();
    }

    function exportData(url) {
        var params = $.extend({toko_id: {{ $toko->id }}}, filterParams());
        window.open(url + '?' + $.param(params), '_blank');
    }
</script>
@endpush
