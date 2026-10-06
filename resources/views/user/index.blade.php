@extends('layouts.master')

@section('title')
    Daftar User
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar User</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box modern-box">
            <div class="box-header">
                <div class="box-header-left">
                    <h3 class="box-title">
                        <i class="fa fa-users"></i>
                        <span>Daftar User</span>
                    </h3>
                    <p class="box-subtitle">Kelola pengguna sistem</p>
                </div>
                <div class="box-header-right">
                    <button onclick="addForm('{{ route('user.store') }}')" class="btn btn-primary btn-action">
                        <i class="fa fa-plus-circle"></i>
                        <span>Tambah User</span>
                    </button>
                </div>
            </div>
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
                                        <i class="fa fa-user"></i>
                                        Nama
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fa fa-envelope"></i>
                                        Email
                                    </div>
                                </th>
                                <th width="12%">
                                    <div class="th-content">
                                        <i class="fa fa-shield-alt"></i>
                                        Level
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('user.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('user.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'name'},
                {data: 'email'},
                {data: 'level_badge', searchable: false, sortable: false},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            }
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title .title-text').text('Tambah User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=name]').focus();

        $('#password, #password_confirmation').attr('required', true);
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title .title-text').text('Edit User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=name]').focus();

        $('#password, #password_confirmation').attr('required', false);

        $.get(url)
            .done((response) => {
                $('#modal-form [name=name]').val(response.name);
                $('#modal-form [name=email]').val(response.email);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteData(url) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus user ini?',
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
                        Swal.fire('Berhasil!', 'User berhasil dihapus', 'success');
                    })
                    .fail((errors) => {
                        Swal.fire('Gagal!', 'Tidak dapat menghapus user', 'error');
                        return;
                    });
            }
        });
    }
</script>
@endpush
