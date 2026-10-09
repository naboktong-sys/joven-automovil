@extends('layouts.master')

@section('title')
    Histori Toko
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Histori Toko</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box modern-box">
            <div class="box-header">
                <div class="box-header-left">
                    <h3 class="box-title">
                        <i class="fa fa-history"></i>
                        <span>Histori Kunjungan Toko</span>
                    </h3>
                    <p class="box-subtitle">Seluruh riwayat kunjungan sales ke toko langganan</p>
                </div>
                <div class="box-header-right">
                    <button type="button" onclick="exportData('{{ route('histori.export_excel') }}')" class="btn btn-success btn-action">
                        <i class="fa fa-file-excel-o"></i>
                        <span>Excel</span>
                    </button>
                    <button type="button" onclick="exportData('{{ route('histori.export_pdf') }}')" class="btn btn-danger btn-action">
                        <i class="fa fa-file-pdf-o"></i>
                        <span>PDF</span>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3">
                        <select id="filter_toko" class="form-control">
                            <option value="">Semua Toko</option>
                            @foreach($toko as $t)
                                <option value="{{ $t->id }}">{{ $t->nama_toko }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" id="filter_tanggal_awal" class="form-control" title="Tanggal awal">
                    </div>
                    <div class="col-md-3">
                        <input type="date" id="filter_tanggal_akhir" class="form-control" title="Tanggal akhir">
                    </div>
                    <div class="col-md-3">
                        <button type="button" onclick="filterData()" class="btn btn-info">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <button type="button" onclick="resetFilter()" class="btn btn-default">
                            <i class="fa fa-refresh"></i> Reset
                        </button>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table id="table-histori" class="table table-modern table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="14%">Tanggal</th>
                                <th>Toko</th>
                                <th width="22%">Alamat</th>
                                <th width="10%">Total Qty</th>
                                <th width="15%">Total Nilai</th>
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
            toko_id: $('#filter_toko').val(),
            tanggal_awal: $('#filter_tanggal_awal').val(),
            tanggal_akhir: $('#filter_tanggal_akhir').val()
        };
    }

    $(function () {
        table = $('#table-histori').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('histori.data') }}',
                data: function (d) {
                    $.extend(d, filterParams());
                }
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal_kunjungan'},
                {data: 'nama_toko'},
                {data: 'alamat_toko'},
                {data: 'total_qty'},
                {data: 'total_nilai'},
                {data: 'aksi', searchable: false, sortable: false}
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari histori...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Tidak ada histori yang ditemukan",
                emptyTable: "Belum ada histori kunjungan",
                paginate: {next: '&raquo;', previous: '&laquo;'}
            }
        });
    });

    function filterData() {
        table.ajax.reload();
    }

    function resetFilter() {
        $('#filter_toko').val('');
        $('#filter_tanggal_awal').val('');
        $('#filter_tanggal_akhir').val('');
        table.ajax.reload();
    }

    function exportData(url) {
        window.open(url + '?' + $.param(filterParams()), '_blank');
    }
</script>
@endpush
