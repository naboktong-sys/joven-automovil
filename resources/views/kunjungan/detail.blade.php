@extends('layouts.master')

@section('title')
    Detail Kunjungan
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-eye"></i>
                    Detail Kunjungan
                </h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('kunjungan.index') }}" class="btn btn-default btn-sm">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-striped">
                            <tr>
                                <th width="30%">Toko</th>
                                <td>{{ $kunjungan->toko->nama_toko }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ tanggal_indonesia($kunjungan->tanggal_kunjungan, true) }}</td>
                            </tr>
                            <tr>
                                <th>Total Qty</th>
                                <td><span class="badge badge-primary">{{ $kunjungan->total_qty }} item</span></td>
                            </tr>
                            <tr>
                                <th>Total Nilai</th>
                                <td><strong class="text-success">Rp {{ format_uang($kunjungan->total_nilai) }}</strong></td>
                            </tr>
                            <tr>
                                <th>Catatan</th>
                                <td>{{ $kunjungan->catatan ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        @if($kunjungan->foto_kunjungan)
                        <div class="text-center">
                            <label>Foto Kunjungan:</label><br>
                            <img src="{{ asset('storage/kunjungan/' . $kunjungan->foto_kunjungan) }}" alt="Foto" class="img-responsive" style="max-height: 300px;">
                        </div>
                        @endif
                    </div>
                </div>

                <hr>

                <h4>Detail Produk</h4>
                <table id="table-detail" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th width="10%">Qty</th>
                            <th width="15%">Harga</th>
                            <th width="15%">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">TOTAL:</th>
                            <th>{{ $kunjungan->total_qty }}</th>
                            <th colspan="2">Rp {{ format_uang($kunjungan->total_nilai) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#table-detail').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('kunjungan.detail.data', $kunjungan->id) }}',
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'nama_produk'},
            {data: 'kategori'},
            {data: 'qty'},
            {data: 'harga'},
            {data: 'subtotal'}
        ],
        paging: false,
        searching: false,
        info: false,
        order: []
    });
});
</script>
@endpush
