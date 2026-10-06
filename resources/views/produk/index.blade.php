@extends('layouts.master')

@section('title')
    Daftar Produk
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Produk</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box modern-box">
            <div class="box-header">
                <div class="box-header-left">
                    <h3 class="box-title">
                        <i class="fa fa-cubes"></i>
                        <span>Daftar Produk Onderdil</span>
                    </h3>
                    <p class="box-subtitle">Kelola semua produk onderdil Anda di sini</p>
                </div>
                <div class="box-header-right">
                    <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-primary btn-action">
                        <i class="fa fa-plus-circle"></i>
                        <span>Tambah</span>
                    </button>
                    <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-danger btn-action">
                        <i class="fa fa-trash"></i>
                        <span>Hapus</span>
                    </button>
                    <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-info btn-action">
                        <i class="fa fa-barcode"></i>
                        <span>Cetak Barcode</span>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <div class="table-wrapper">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th width="5%">
                                    <input type="checkbox" name="select_all" id="select_all">
                                </th>
                                <th width="5%">No</th>
                                <th width="8%">Gambar</th>
                                <th width="10%">Kode</th>
                                <th>Nama</th>
                                <th width="12%">Kategori</th>
                                <th width="10%">Merk</th>
                                <th width="10%">H. Beli</th>
                                <th width="10%">H. Jual</th>
                                <th width="8%">Stok</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('produk.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            serverSide: true,
            ajax: {
                url: '{{ route('produk.data') }}',
            },
            columns: [
                {data: 'select_all', searchable: false, sortable: false},
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'gambar', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'nama_kategori'},
                {data: 'merk'},
                {data: 'harga_beli'},
                {data: 'harga_jual'},
                {data: 'stok'},
                {data: 'aksi', searchable: false, sortable: false},
            ],
            language: {
                processing: '<div class="loading-spinner"><div class="spinner"></div><p>Memuat data...</p></div>',
                search: "",
                searchPlaceholder: "Cari produk...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                zeroRecords: '<div class="empty-state"><i class="fa fa-inbox"></i><p>Tidak ada data yang ditemukan</p></div>',
                emptyTable: '<div class="empty-state"><i class="fa fa-cubes"></i><p>Belum ada produk</p></div>',
                paginate: {
                    first: '<i class="fa fa-angle-double-left"></i>',
                    last: '<i class="fa fa-angle-double-right"></i>',
                    next: '<i class="fa fa-angle-right"></i>',
                    previous: '<i class="fa fa-angle-left"></i>'
                }
            },
            dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            drawCallback: function() {
                $('.dataTables_paginate > .pagination').addClass('pagination-modern');
            }
        });

        // Enhanced search input
        $('.dataTables_filter input').addClass('search-input');
        $('.dataTables_filter label').prepend('<i class="fa fa-search search-icon"></i>');

        $('[name=select_all]').on('click', function () {
            $(':checkbox').prop('checked', this.checked);
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.ajax({
                    url: $('#modal-form form').attr('action'),
                    type: 'post',
                    data: new FormData($('#modal-form form')[0]),
                    async: false,
                    processData: false,
                    contentType: false
                })
                .done((response) => {
                    $('#modal-form').modal('hide');
                    table.ajax.reload();
                    showNotification('success', 'Berhasil!', 'Data produk berhasil disimpan');
                })
                .fail((errors) => {
                    showNotification('error', 'Gagal!', 'Tidak dapat menyimpan data');
                    return;
                });
            }
        });
    });

    function addForm(url) {
        $('#modal-form').modal({backdrop: 'static', keyboard: false});
        $('#modal-form .modal-title .title-text').text('Tambah Produk');
        $('#modal-form [name=_method]').val('post');
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=nama_produk]').focus();

        $('#modal-form .preview').hide();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=kode_produk]').val(response);
            })
            .fail((errors) => {
                showNotification('error', 'Gagal!', 'Tidak dapat menghasilkan kode produk');
                return;
            });
    }

    function editForm(url) {
        $('#modal-form').modal({backdrop: 'static', keyboard: false});
        $('#modal-form .modal-title .title-text').text('Edit Produk');
        $('#modal-form [name=_method]').val('put');
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=nama_produk]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_produk]').val(response.nama_produk);
                $('#modal-form [name=id_kategori]').val(response.id_kategori);
                $('#modal-form [name=merk]').val(response.merk);
                $('#modal-form [name=harga_beli]').val(response.harga_beli);
                $('#modal-form [name=harga_jual]').val(response.harga_jual);
                $('#modal-form [name=diskon]').val(response.diskon);
                $('#modal-form [name=stok]').val(response.stok);
                $('#modal-form [name=kode_produk]').val(response.kode_produk);

                if (response.gambar) {
                    $('#modal-form .preview').show();
                    $('#modal-form .preview img').attr('src', response.gambar);
                } else {
                    $('#modal-form .preview').hide();
                }
            })
            .fail((errors) => {
                showNotification('error', 'Gagal!', 'Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteData(url) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus produk ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#95a5a6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        table.ajax.reload();
                        showNotification('success', 'Berhasil!', 'Data produk berhasil dihapus');
                    })
                    .fail((errors) => {
                        showNotification('error', 'Gagal!', 'Tidak dapat menghapus data');
                        return;
                    });
            }
        });
    }

    function deleteSelected(url) {
        var ids = [];
        $('[name="id_produk[]"]:checked').each(function () {
            ids.push($(this).val());
        });

        if (ids.length < 1) {
            Swal.fire('Peringatan', 'Pilih produk yang akan dihapus terlebih dahulu', 'warning');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus ' + ids.length + ' produk yang dipilih?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#95a5a6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete',
                        'id_produk': ids
                    })
                    .done((response) => {
                        table.ajax.reload();
                        showNotification('success', 'Berhasil!', ids.length + ' produk berhasil dihapus');
                    })
                    .fail((errors) => {
                        showNotification('error', 'Gagal!', 'Tidak dapat menghapus data');
                        return;
                    });
            }
        });
    }

    function cetakBarcode(url) {
        var ids = [];
        $('[name="id_produk[]"]:checked').each(function () {
            ids.push($(this).val());
        });

        if (ids.length < 1) {
            Swal.fire('Peringatan', 'Pilih produk yang akan dicetak barcodenya terlebih dahulu', 'warning');
            return;
        }

        window.open(url + '?id_produk=' + ids.join(','), '_blank');
    }

    // Notification helper function
    function showNotification(type, title, message) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        Toast.fire({
            icon: type,
            title: title,
            text: message
        });
    }
</script>
@endpush
