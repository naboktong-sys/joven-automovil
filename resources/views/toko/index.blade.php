@extends('layouts.master')

@section('title')
    Daftar Toko Langganan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Toko Langganan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box modern-box">
            <!-- Box Header -->
            <div class="box-header">
                <div class="box-header-left">
                    <h3 class="box-title">
                        <i class="fa fa-building"></i>
                        <span>Daftar Toko Langganan</span>
                    </h3>
                    <p class="box-subtitle">Kelola toko langganan Anda di sini</p>
                </div>
                <div class="box-header-right">
                    <button onclick="addForm('{{ route('toko.store') }}')" class="btn btn-primary btn-action">
                        <i class="fa fa-plus-circle"></i>
                        <span>Tambah Toko</span>
                    </button>
                </div>
            </div>

            <!-- Box Body -->
            <div class="box-body">
                <div class="table-wrapper">
                    <table class="table table-modern table-striped">
                        <thead>
                            <tr>
                                <th width="5%">
                                    <div class="th-content">No</div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fa fa-building"></i>
                                        Nama Toko
                                    </div>
                                </th>
                                <th width="25%">
                                    <div class="th-content">
                                        <i class="fa fa-map-marker-alt"></i>
                                        Alamat
                                    </div>
                                </th>
                                <th width="15%">
                                    <div class="th-content">
                                        <i class="fa fa-phone"></i>
                                        Kontak
                                    </div>
                                </th>
                                <th width="10%">
                                    <div class="th-content">
                                        <i class="fa fa-history"></i>
                                        Kunjungan
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

@includeIf('toko.form')
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
                url: '{{ route('toko.data') }}'
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nama_toko'},
                {data: 'alamat_short'},
                {data: 'kontak'},
                {data: 'total_kunjungan'},
                {data: 'aksi', searchable: false, sortable: false}
            ],
            language: {
                processing: '<div class="loading-spinner"><div class="spinner"></div><p>Memuat data...</p></div>',
                search: "",
                searchPlaceholder: "Cari toko...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                zeroRecords: '<div class="empty-state"><i class="fa fa-inbox"></i><p>Tidak ada data yang ditemukan</p></div>',
                emptyTable: '<div class="empty-state"><i class="fa fa-building"></i><p>Belum ada toko langganan</p></div>',
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

        // FORM SUBMIT DENGAN FORMDATA (untuk handle upload file)
        $('#modal-form').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData($('#form-toko')[0]); // ✅ Sesuai dengan ID di form

            $.ajax({
                url: $('#modal-form form').attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#modal-form').modal('hide');
                    table.ajax.reload();
                    showNotification('success', 'Berhasil!', 'Data toko berhasil disimpan');
                },
                error: function(xhr) {
                    let message = 'Tidak dapat menyimpan data';

                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        } else if (xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            message = Object.values(errors).flat().join(', ');
                        }
                    }

                    showNotification('error', 'Gagal!', message);
                    console.error('Error details:', xhr.responseJSON);
                }
            });
        });
    });

    function addForm(url) {
        $('#modal-form').modal({backdrop: 'static', keyboard: false});
        $('#modal-form .modal-title .title-text').text('Tambah Toko');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_toko]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal({backdrop: 'static', keyboard: false});
        $('#modal-form .modal-title .title-text').text('Edit Toko');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_toko]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_toko]').val(response.nama_toko);
                $('#modal-form [name=alamat]').val(response.alamat);
                $('#modal-form [name=kontak]').val(response.kontak);
                $('#modal-form [name=latitude]').val(response.latitude);
                $('#modal-form [name=longitude]').val(response.longitude);
                $('#modal-form [name=catatan]').val(response.catatan);
            })
            .fail((errors) => {
                showNotification('error', 'Gagal!', 'Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteData(url) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus toko ini?',
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
                        showNotification('success', 'Berhasil!', 'Data toko berhasil dihapus');
                    })
                    .fail((errors) => {
                        if (errors.responseJSON && errors.responseJSON.message) {
                            showNotification('error', 'Gagal!', errors.responseJSON.message);
                        } else {
                            showNotification('error', 'Gagal!', 'Tidak dapat menghapus data');
                        }
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
