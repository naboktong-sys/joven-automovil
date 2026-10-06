@extends('layouts.master')

@section('title')
    Daftar Kategori
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Kategori</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box modern-box">
            <!-- Box Header -->
            <div class="box-header">
                <div class="box-header-left">
                    <h3 class="box-title">
                        <i class="fa fa-cube"></i>
                        <span>Daftar Kategori</span>
                    </h3>
                    <p class="box-subtitle">Kelola kategori produk Anda di sini</p>
                </div>
                <div class="box-header-right">
                    <button onclick="addForm('{{ route('kategori.store') }}')" class="btn btn-primary btn-action">
                        <i class="fa fa-plus-circle"></i>
                        <span>Tambah Kategori</span>
                    </button>
                </div>
            </div>

            <!-- Box Body -->
            <div class="box-body">
                <div class="table-wrapper">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th width="8%">
                                    <div class="th-content">No</div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fa fa-cube"></i>
                                        Nama Kategori
                                    </div>
                                </th>
                                <th width="15%">
                                    <div class="th-content">
                                        <i class="fa fa-cog"></i>
                                        Aksi
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('kategori.form')
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
                url: '{{ route('kategori.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nama_kategori'},
                {data: 'aksi', searchable: false, sortable: false},
            ],
            language: {
                processing: '<div class="loading-spinner"><div class="spinner"></div><p>Memuat data...</p></div>',
                search: "",
                searchPlaceholder: "Cari kategori...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                zeroRecords: '<div class="empty-state"><i class="fa fa-inbox"></i><p>Tidak ada data yang ditemukan</p></div>',
                emptyTable: '<div class="empty-state"><i class="fa fa-cube"></i><p>Belum ada kategori</p></div>',
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

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();

                        // Show success notification
                        showNotification('success', 'Berhasil!', 'Data kategori berhasil disimpan');
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
        $('#modal-form .modal-title .title-text').text('Tambah Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_kategori]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal({backdrop: 'static', keyboard: false});
        $('#modal-form .modal-title .title-text').text('Edit Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_kategori]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_kategori]').val(response.nama_kategori);
            })
            .fail((errors) => {
                showNotification('error', 'Gagal!', 'Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteData(url) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus kategori ini?',
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
                        showNotification('success', 'Berhasil!', 'Data kategori berhasil dihapus');
                    })
                    .fail((errors) => {
                        showNotification('error', 'Gagal!', 'Tidak dapat menghapus data');
                        return;
                    });
            }
        });
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
