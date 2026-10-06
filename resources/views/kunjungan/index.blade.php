@extends('layouts.master')

@section('title')
    Daftar Kunjungan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Kunjungan</li>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/_kunjungan.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box modern-box">
            <div class="box-header">
                <div class="box-header-left">
                    <h3 class="box-title">
                        <i class="fa fa-list-alt"></i>
                        <span>Daftar Kunjungan Sales</span>
                    </h3>
                    <p class="box-subtitle">Histori semua kunjungan ke toko</p>
                </div>
                <div class="box-header-right">
                    <a href="{{ route('kunjungan.create') }}" class="btn btn-primary btn-action">
                        <i class="fa fa-plus-circle"></i>
                        <span>Tambah Kunjungan</span>
                    </a>
                </div>
            </div>

            <div class="box-body">
                <!-- Filter -->
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
                        <input type="date" id="filter_tanggal_awal" class="form-control" placeholder="Tanggal Awal">
                    </div>
                    <div class="col-md-3">
                        <input type="date" id="filter_tanggal_akhir" class="form-control" placeholder="Tanggal Akhir">
                    </div>
                    <div class="col-md-3">
                        <button onclick="filterData()" class="btn btn-info">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <button onclick="resetFilter()" class="btn btn-default">
                            <i class="fa fa-refresh"></i> Reset
                        </button>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table id="table-kunjungan" class="table table-modern table-striped">
                        <thead>
                            <tr>
                                <th width="5%"><div class="th-content">No</div></th>
                                <th width="12%"><div class="th-content"><i class="fa fa-calendar"></i> Tanggal</div></th>
                                <th><div class="th-content"><i class="fa fa-building"></i> Toko</div></th>
                                <th width="10%"><div class="th-content"><i class="fa fa-boxes"></i> Total Qty</div></th>
                                <th width="15%"><div class="th-content"><i class="fa fa-money-bill"></i> Total Nilai</div></th>
                                <th width="20%"><div class="th-content"><i class="fa fa-cog"></i> Aksi</div></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== MODAL EDIT KUNJUNGAN ===== --}}
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" style="width: 860px; max-width: 95vw;">
        <div class="modal-content">

            <div class="modal-header" style="background: linear-gradient(135deg, #f39c12, #e67e22); color:#fff; border-radius:4px 4px 0 0; padding:12px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;font-size:22px;">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Kunjungan</h4>
            </div>

            <div class="modal-body" style="padding:0;">
                <div id="edit-alert" class="alert" style="display:none; margin:15px 15px 0; border-radius:4px;"></div>

                <ul class="nav nav-tabs" style="margin:15px 15px 0; border-bottom:2px solid #f39c12;">
                    <li class="active">
                        <a href="#tab-info" data-toggle="tab" style="border-radius:4px 4px 0 0;">
                            <i class="fa fa-info-circle"></i> Info Dasar
                        </a>
                    </li>
                    <li>
                        <a href="#tab-produk" data-toggle="tab" id="tab-produk-link" style="border-radius:4px 4px 0 0;">
                            <i class="fa fa-boxes"></i> Produk
                            <span id="badge-produk" class="badge" style="background:#f39c12; margin-left:4px;">0</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content" style="padding:20px 15px;">

                    {{-- TAB 1: INFO DASAR --}}
                    <div class="tab-pane active" id="tab-info">
                        <form id="formEdit" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fa fa-building"></i> Pilih Toko <span class="text-danger">*</span></label>
                                        <select name="toko_id" id="edit_toko_id" class="form-control" required>
                                            <option value="">-- Pilih Toko --</option>
                                            @foreach($toko as $t)
                                                <option value="{{ $t->id }}">{{ $t->nama_toko }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fa fa-calendar"></i> Tanggal Kunjungan <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_kunjungan" id="edit_tanggal_kunjungan" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><i class="fa fa-sticky-note"></i> Catatan</label>
                                <textarea name="catatan" id="edit_catatan" class="form-control" rows="3" placeholder="Catatan kunjungan (opsional)..."></textarea>
                            </div>

                            <div class="form-group">
                                <label><i class="fa fa-image"></i> Foto Kunjungan</label>
                                <div id="edit_foto_preview_wrap" style="display:none; margin-bottom:10px;">
                                    <p class="text-muted" style="font-size:12px; margin-bottom:5px;">Foto saat ini:</p>
                                    <img id="edit_foto_preview" src="" alt="Foto" class="img-thumbnail" style="max-height:160px;">
                                </div>
                                <input type="file" name="foto_kunjungan" id="edit_foto_kunjungan" class="form-control" accept="image/jpeg,image/png,image/jpg">
                                <p class="help-block" style="font-size:11px; color:#999;">
                                    <i class="fa fa-info-circle"></i> Kosongkan jika tidak ingin ganti foto. Maks. 2MB.
                                </p>
                            </div>

                            <div class="text-right" style="margin-top:10px;">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    <i class="fa fa-times"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-warning" id="btnSimpanEdit">
                                    <i class="fa fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- TAB 2: EDIT PRODUK --}}
                    <div class="tab-pane" id="tab-produk">

                        {{-- Panel tambah produk — pakai class sama dengan create.blade --}}
                        <div style="background:#fff; border:1.5px solid #e2e8f0; border-radius:10px; margin-bottom:16px; overflow:hidden;">
                            <div style="background:#fef9f0; padding:10px 16px; border-bottom:1px solid #fde8c0;">
                                <strong style="font-size:13px; color:#d97706;"><i class="fa fa-plus-circle"></i> Tambah Produk</strong>
                            </div>
                            <div style="padding:14px 16px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label style="font-size:12px; font-weight:600; color:#475569; margin-bottom:6px; display:block;">Cari Produk</label>

                                        <input type="hidden" id="modal_pid">

                                        {{-- ① Search bar — class sama persis dengan _kunjungan.css --}}
                                        <div id="modal-produk-container">
                                            <div class="produk-search-wrap">
                                                <i class="fa fa-search ico-search"></i>
                                                <input type="text"
                                                       class="produk-search-input"
                                                       id="modal_ac"
                                                       placeholder="Ketik nama produk..."
                                                       autocomplete="off">
                                                <button type="button" class="btn-clear-input" id="modal_clear"
                                                        onclick="clearModalProduk()" style="display:none;">&times;</button>
                                            </div>

                                            {{-- ② Hasil pencarian inline --}}
                                            <div class="search-panel" id="modal_dd"></div>

                                            {{-- ③ Produk terpilih --}}
                                            <div class="selected-produk-box" id="modal_sel">
                                                <div class="sel-icon"><i class="fa fa-check"></i></div>
                                                <div class="sel-body">
                                                    <div class="sel-name" id="modal_sel_name"></div>
                                                    <div class="sel-meta" id="modal_sel_meta"></div>
                                                </div>
                                                <button type="button" class="btn-ganti" onclick="clearModalProduk()">
                                                    <i class="fa fa-pencil"></i> Ganti Produk
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label style="font-size:12px; font-weight:600; color:#475569; margin-bottom:6px; display:block;">Qty</label>
                                        <input type="number" id="new_qty" class="form-control" min="1" value="1" placeholder="Qty">
                                    </div>
                                    <div class="col-md-3">
                                        <label style="font-size:12px; visibility:hidden; display:block; margin-bottom:6px;">-</label>
                                        <button type="button" class="btn btn-success btn-block" id="btnTambahProduk">
                                            <i class="fa fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Alert produk --}}
                        <div id="produk-alert" class="alert" style="display:none; border-radius:4px;"></div>

                        {{-- Tabel produk --}}
                        <p style="font-size:12px; color:#666; margin-bottom:8px;">
                            <i class="fa fa-list"></i> <strong>Daftar produk dalam kunjungan ini:</strong>
                        </p>
                        <div id="loading-produk" class="text-center" style="padding:20px; display:none;">
                            <i class="fa fa-spinner fa-spin fa-2x text-warning"></i>
                            <p style="margin-top:8px; color:#888;">Memuat produk...</p>
                        </div>
                        <table class="table table-bordered table-condensed">
                            <thead style="background:#f5f5f5;">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Produk</th>
                                    <th width="10%" class="text-center">Qty</th>
                                    <th width="18%">Harga Satuan</th>
                                    <th width="18%">Subtotal</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-produk-edit">
                                <tr id="tr-empty-produk">
                                    <td colspan="6" class="text-center text-muted" style="padding:20px;">
                                        <i class="fa fa-inbox fa-2x"></i><br>Belum ada produk
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr style="background:#fef9f0; font-weight:bold;">
                                    <td colspan="2" class="text-right">TOTAL:</td>
                                    <td id="footer-total-qty" class="text-center">0</td>
                                    <td></td>
                                    <td id="footer-total-nilai" class="text-success">Rp 0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let table;
let currentEditId = null;

// ===== DATA PRODUK =====
const PRODUK_LIST = {!! json_encode(\App\Models\Produk::orderBy('nama_produk')->get()->map(function($p) {
    return ['id' => $p->id_produk, 'nama' => $p->nama_produk, 'stok' => $p->stok, 'harga' => $p->harga_jual];
})) !!};

function formatRupiah(n) {
    return 'Rp ' + parseInt(n || 0).toLocaleString('id-ID');
}
function stripTags(str) {
    return String(str || '').replace(/<[^>]*>/g, '').trim();
}
function hlText(text, q) {
    if (!q) return text;
    return text.replace(new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi'), '<mark>$1</mark>');
}

// ===== AUTOCOMPLETE MODAL — pakai class sama persis dengan _kunjungan.css =====
(function initModalAutocomplete() {
    let input, panel, activeIdx = -1;

    function ready() {
        input = document.getElementById('modal_ac');
        panel = document.getElementById('modal_dd');
        if (!input || !panel) return;

        input.addEventListener('input', function() {
            document.getElementById('modal_pid').value = '';
            input.classList.remove('selected');
            document.getElementById('modal_clear').style.display = 'none';
            document.getElementById('modal_sel').classList.remove('show');
            render(this.value);
        });

        input.addEventListener('keydown', function(e) {
            let items = panel.querySelectorAll('.sp-item');
            if (!items.length) return;
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeIdx = Math.min(activeIdx + 1, items.length - 1);
                items.forEach((el, i) => el.classList.toggle('active', i === activeIdx));
                items[activeIdx]?.scrollIntoView({ block: 'nearest' });
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeIdx = Math.max(activeIdx - 1, 0);
                items.forEach((el, i) => el.classList.toggle('active', i === activeIdx));
                items[activeIdx]?.scrollIntoView({ block: 'nearest' });
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (activeIdx >= 0) items[activeIdx].click();
            } else if (e.key === 'Escape') {
                panel.classList.remove('open');
            }
        });
    }

    function render(query) {
        if (!panel) return;
        let q = (query || '').trim();
        if (!q) { panel.classList.remove('open'); return; }

        let list  = PRODUK_LIST.filter(p => p.nama.toLowerCase().includes(q.toLowerCase()));
        let shown = list.slice(0, 30);
        let html  = '';

        if (!shown.length) {
            html = `
            <div class="sp-empty">
                <div class="sp-empty-icon"><i class="fa fa-search"></i></div>
                <div class="sp-empty-text">Produk tidak ditemukan</div>
                <div class="sp-empty-sub">Coba kata kunci lain</div>
            </div>`;
        } else {
            html += `
            <div class="sp-topbar">
                <span class="sp-topbar-label"><i class="fa fa-list fa-fw"></i> Hasil Pencarian</span>
                <span class="sp-topbar-count">${shown.length} produk</span>
            </div>
            <div class="sp-list">`;
            shown.forEach(p => {
                let isLow  = p.stok <= 5;
                let bClass = isLow ? 'low' : 'ok';
                let bIcon  = isLow ? 'fa-exclamation-circle' : 'fa-check-circle';
                let bLabel = isLow ? `Sisa ${p.stok}` : `Stok ${p.stok}`;
                html += `
                <div class="sp-item"
                     data-id="${p.id}" data-nama="${p.nama}"
                     data-stok="${p.stok}" data-harga="${p.harga}"
                     onclick="selectModalProduk(this)">
                    <div class="sp-item-icon"><i class="fa fa-box"></i></div>
                    <div class="sp-item-body">
                        <div class="sp-item-name">${hlText(p.nama, q)}</div>
                        <div class="sp-item-price">${formatRupiah(p.harga)}</div>
                    </div>
                    <div class="sp-item-right">
                        <span class="badge-stok ${bClass}">
                            <i class="fa ${bIcon}"></i> ${bLabel}
                        </span>
                    </div>
                    <i class="fa fa-chevron-right sp-item-arrow"></i>
                </div>`;
            });
            html += '</div>';
        }

        panel.innerHTML = html;
        panel.classList.add('open');
        activeIdx = -1;
    }

    window._renderModalAc = render;
    document.addEventListener('DOMContentLoaded', ready);
    document.addEventListener('shown.bs.modal', ready);
})();

function selectModalProduk(el) {
    let id    = el.dataset.id;
    let nama  = el.dataset.nama;
    let stok  = el.dataset.stok;
    let harga = el.dataset.harga;

    document.getElementById('modal_pid').value = id;

    let ac = document.getElementById('modal_ac');
    ac.value = nama;
    ac.classList.add('selected');
    document.getElementById('modal_clear').style.display = 'block';
    document.getElementById('modal_dd').classList.remove('open');

    document.getElementById('modal_sel_name').textContent = nama;
    document.getElementById('modal_sel_meta').textContent = formatRupiah(harga) + '  •  Stok: ' + stok;
    document.getElementById('modal_sel').classList.add('show');

    document.getElementById('new_qty').max = stok;
    document.getElementById('new_qty').focus();
}

function clearModalProduk() {
    document.getElementById('modal_pid').value = '';
    let ac = document.getElementById('modal_ac');
    ac.value = '';
    ac.classList.remove('selected');
    document.getElementById('modal_clear').style.display = 'none';
    document.getElementById('modal_sel').classList.remove('show');
    document.getElementById('modal_dd').classList.remove('open');
    ac.focus();
}

// ===== DATATABLE =====
$(function () {
    table = $('#table-kunjungan').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ route('kunjungan.data') }}',
            data: function(d) {
                d.toko_id       = $('#filter_toko').val();
                d.tanggal_awal  = $('#filter_tanggal_awal').val();
                d.tanggal_akhir = $('#filter_tanggal_akhir').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, orderable: false},
            {data: 'tanggal_kunjungan'},
            {data: 'nama_toko'},
            {data: 'total_qty'},
            {data: 'total_nilai'},
            {data: 'aksi', searchable: false, orderable: false}
        ],
        language: {
            processing: '<div class="loading-spinner"><div class="spinner"></div><p>Memuat data...</p></div>',
            search: "", searchPlaceholder: "Cari kunjungan...",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data",
            infoFiltered: "(disaring dari _MAX_ total data)",
            zeroRecords: '<div class="empty-state"><i class="fa fa-inbox"></i><p>Tidak ada data</p></div>',
            emptyTable: '<div class="empty-state"><i class="fa fa-list-alt"></i><p>Belum ada kunjungan</p></div>',
            paginate: {
                first: '<i class="fa fa-angle-double-left"></i>',
                last:  '<i class="fa fa-angle-double-right"></i>',
                next:  '<i class="fa fa-angle-right"></i>',
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

    $('.dataTables_filter input').addClass('search-input');
    $('.dataTables_filter label').prepend('<i class="fa fa-search search-icon"></i>');

    // ===== TOMBOL TAMBAH PRODUK =====
    $('#btnTambahProduk').on('click', function() {
        let pid = document.getElementById('modal_pid').value;
        let qty = parseInt($('#new_qty').val());

        if (!pid) { showProdukAlert('warning', 'Pilih produk terlebih dahulu!'); return; }
        if (!qty || qty < 1) { showProdukAlert('warning', 'Qty minimal 1!'); return; }

        let stok = parseInt(document.getElementById('new_qty').max) || 9999;
        if (qty > stok) { showProdukAlert('warning', `Stok tidak mencukupi! Tersedia: ${stok}`); return; }

        let btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: '{{ route('kunjungan.add_produk') }}',
            method: 'POST',
            data: {
                _token: $('meta[name=csrf-token]').attr('content'),
                kunjungan_id: currentEditId,
                produk_id: pid,
                qty: qty
            },
            success: function(res) {
                if (res.success) {
                    showProdukAlert('success', res.message);
                    loadProdukEdit(currentEditId);
                    table.ajax.reload(null, false);
                    clearModalProduk();
                    $('#new_qty').val(1);
                } else {
                    showProdukAlert('danger', res.message);
                }
            },
            error: function(xhr) {
                showProdukAlert('danger', xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan');
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="fa fa-plus"></i> Tambah');
            }
        });
    });

    // ===== FORM EDIT INFO DASAR =====
    $('#formEdit').on('submit', function(e) {
        e.preventDefault();
        if (!currentEditId) return;
        let formData = new FormData(this);
        $('#btnSimpanEdit').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
        $('#edit-alert').hide();

        $.ajax({
            url: '/kunjungan/' + currentEditId,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-HTTP-Method-Override': 'PUT' },
            success: function(res) {
                if (res.success) {
                    showNotification('success', 'Berhasil!', res.message);
                    $('#modalEdit').modal('hide');
                    table.ajax.reload(null, false);
                } else {
                    showEditAlert('danger', res.message);
                }
            },
            error: function(xhr) {
                let msg = 'Gagal menyimpan';
                if (xhr.responseJSON && xhr.responseJSON.errors)
                    msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                else if (xhr.responseJSON && xhr.responseJSON.message)
                    msg = xhr.responseJSON.message;
                showEditAlert('danger', msg);
            },
            complete: function() {
                $('#btnSimpanEdit').prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Perubahan');
            }
        });
    });

    // ===== LOAD PRODUK SAAT TAB DIKLIK =====
    $('a[href="#tab-produk"]').on('shown.bs.tab', function() {
        if (currentEditId) loadProdukEdit(currentEditId);
    });

    // ===== PREVIEW FOTO =====
    $('#edit_foto_kunjungan').on('change', function() {
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = e => {
                $('#edit_foto_preview').attr('src', e.target.result);
                $('#edit_foto_preview_wrap').show();
            };
            reader.readAsDataURL(file);
        }
    });

    // ===== RESET MODAL =====
    $('#modalEdit').on('hidden.bs.modal', function() {
        currentEditId = null;
        $('#formEdit')[0].reset();
        $('#edit-alert, #produk-alert').hide();
        $('#edit_foto_preview_wrap').hide();
        clearModalProduk();
        $('#new_qty').val(1);
        $('#tbody-produk-edit').html(`
            <tr id="tr-empty-produk">
                <td colspan="6" class="text-center text-muted" style="padding:20px;">
                    <i class="fa fa-inbox fa-2x"></i><br>Belum ada produk
                </td>
            </tr>`);
        $('#badge-produk').text('0');
        $('#footer-total-qty').text('0');
        $('#footer-total-nilai').text('Rp 0');
        $('a[href="#tab-info"]').tab('show');
    });
});

// ===== LOAD TABEL PRODUK EDIT =====
function loadProdukEdit(id) {
    $('#loading-produk').show();
    $('#tbody-produk-edit').html('');

    $.get(`/kunjungan/${id}/detail/data`, function(res) {
        let rows = res.data || [];
        let totalQty   = 0;
        let totalNilai = 0;
        let html = '';

        if (rows.length === 0) {
            html = `<tr id="tr-empty-produk">
                        <td colspan="6" class="text-center text-muted" style="padding:20px;">
                            <i class="fa fa-inbox fa-2x"></i><br>Belum ada produk
                        </td>
                    </tr>`;
        } else {
            rows.forEach(function(item, idx) {
                let qty      = stripTags(item.qty);
                let harga    = stripTags(item.harga);
                let subtotal = stripTags(item.subtotal);
                totalQty += parseInt(qty) || 0;
                totalNilai += parseInt(String(subtotal).replace(/[^0-9]/g, '')) || 0;
                html += `
                <tr>
                    <td class="text-center">${idx + 1}</td>
                    <td>${item.nama_produk}</td>
                    <td class="text-center"><span class="badge badge-primary">${qty}</span></td>
                    <td>${harga}</td>
                    <td><strong>${subtotal}</strong></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-xs btn-danger btn-flat"
                                onclick="hapusDetailProduk(${item.id}, this)" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
            });
        }

        $('#tbody-produk-edit').html(html);
        $('#badge-produk').text(rows.length);
        $('#footer-total-qty').text(totalQty);
        $('#footer-total-nilai').text(formatRupiah(totalNilai));
    }).fail(function() {
        $('#tbody-produk-edit').html(`<tr><td colspan="6" class="text-center text-danger" style="padding:15px;">
            <i class="fa fa-exclamation-circle"></i> Gagal memuat produk. Coba lagi.</td></tr>`);
    }).always(function() {
        $('#loading-produk').hide();
    });
}

// ===== HAPUS DETAIL =====
function hapusDetailProduk(detailId, btn) {
    if (!confirm('Yakin hapus produk ini? Stok akan dikembalikan.')) return;
    $(btn).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

    $.ajax({
        url: `/kunjungan/detail/${detailId}`,
        method: 'POST',
        data: { _token: $('meta[name=csrf-token]').attr('content'), _method: 'DELETE' },
        success: function(res) {
            if (res.success) {
                showProdukAlert('success', res.message);
                loadProdukEdit(currentEditId);
                table.ajax.reload(null, false);
            } else {
                showProdukAlert('danger', res.message);
                $(btn).prop('disabled', false).html('<i class="fa fa-trash"></i>');
            }
        },
        error: function(xhr) {
            showProdukAlert('danger', xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan');
            $(btn).prop('disabled', false).html('<i class="fa fa-trash"></i>');
        }
    });
}

// ===== FILTER =====
function filterData()  { table.ajax.reload(); }
function resetFilter() {
    $('#filter_toko, #filter_tanggal_awal, #filter_tanggal_akhir').val('');
    table.ajax.reload();
}
function showDetail(url) { window.location.href = url; }

// ===== BUKA MODAL EDIT =====
function editData(id, editUrl) {
    currentEditId = id;
    $('#edit-alert, #produk-alert').hide();
    $('#edit_foto_preview_wrap').hide();
    clearModalProduk();
    $('#btnSimpanEdit').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memuat...');
    $('a[href="#tab-info"]').tab('show');
    $('#modalEdit').modal('show');

    $.get(editUrl, function(data) {
        $('#edit_toko_id').val(data.toko_id);
        $('#edit_tanggal_kunjungan').val(data.tanggal_kunjungan_raw);
        $('#edit_catatan').val(data.catatan || '');
        if (data.foto_url) {
            $('#edit_foto_preview').attr('src', data.foto_url);
            $('#edit_foto_preview_wrap').show();
        }
        $('#btnSimpanEdit').prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Perubahan');

        $.get(`/kunjungan/${id}/detail/data`, function(res) {
            $('#badge-produk').text((res.data || []).length);
        });
    }).fail(function() {
        showEditAlert('danger', 'Gagal memuat data. Silakan coba lagi.');
        $('#btnSimpanEdit').prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Perubahan');
    });
}

// ===== HAPUS KUNJUNGAN =====
function deleteData(url) {
    Swal.fire({
        title: 'Konfirmasi', text: 'Yakin ingin menghapus kunjungan ini? Stok akan dikembalikan.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#e74c3c', cancelButtonColor: '#95a5a6',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal', reverseButtons: true
    }).then(result => {
        if (result.isConfirmed) {
            $.post(url, { '_token': $('meta[name=csrf-token]').attr('content'), '_method': 'delete' })
            .done(() => { table.ajax.reload(); showNotification('success', 'Berhasil!', 'Kunjungan berhasil dihapus'); })
            .fail(() => { showNotification('error', 'Gagal!', 'Tidak dapat menghapus data'); });
        }
    });
}

// ===== HELPERS =====
function showEditAlert(type, msg) {
    let icon = type === 'danger' ? 'exclamation-circle' : 'check-circle';
    $('#edit-alert').removeClass('alert-success alert-danger alert-warning alert-info')
        .addClass('alert-' + type).html(`<i class="fa fa-${icon}"></i> ${msg}`).show();
}
function showProdukAlert(type, msg) {
    let icon = type === 'success' ? 'check-circle' : (type === 'danger' ? 'exclamation-circle' : 'exclamation-triangle');
    $('#produk-alert').removeClass('alert-success alert-danger alert-warning alert-info')
        .addClass('alert-' + type).html(`<i class="fa fa-${icon}"></i> ${msg}`)
        .stop(true).fadeIn().delay(3500).fadeOut();
}
function showNotification(type, title, msg) {
    Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true })
        .fire({ icon: type, title: title, text: msg });
}
</script>
@endpush
