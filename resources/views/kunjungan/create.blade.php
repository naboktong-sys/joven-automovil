@extends('layouts.master')

@section('title')
    Tambah Kunjungan
@endsection

@push('styles')
{{-- CSS halaman kunjungan: letakkan file _kunjungan.css di public/css/pages/ --}}
<link rel="stylesheet" href="{{ asset('css/pages/_kunjungan.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box" style="border-radius:12px;">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-plus-circle text-primary"></i>
                    Tambah Kunjungan Baru
                </h3>
            </div>

            <form action="{{ route('kunjungan.store') }}" method="post"
                  enctype="multipart/form-data" id="form-kunjungan">
                @csrf
                <div class="box-body">

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    {{-- Toko & Tanggal --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('toko_id') ? 'has-error' : '' }}">
                                <label class="control-label">Pilih Toko <span class="text-danger">*</span></label>
                                <select name="toko_id" class="form-control" required>
                                    <option value="">-- Pilih Toko --</option>
                                    @foreach($toko as $t)
                                        <option value="{{ $t->id }}" {{ old('toko_id') == $t->id ? 'selected' : '' }}>
                                            {{ $t->nama_toko }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has('toko_id'))
                                    <span class="help-block">{{ $errors->first('toko_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_kunjungan" class="form-control"
                                       value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" required>
                            </div>
                        </div>
                    </div>

                    <hr style="margin: 8px 0 20px;">

                    {{-- Header Produk --}}
                    <div style="display:flex; align-items:center; margin-bottom:14px;">
                        <strong style="font-size:15px; color:#1e293b;">
                            <i class="fa fa-shopping-cart" style="color:#3498db;"></i>
                            Produk yang Dibeli
                        </strong>
                        <span style="font-size:12px; color:#94a3b8; margin-left:10px;">
                            — Cari dan pilih produk, lalu atur jumlah
                        </span>
                    </div>

                    <div id="produk-container"></div>

                    <button type="button" class="btn-add-row" onclick="addProdukRow()">
                        <i class="fa fa-plus-circle"></i> &nbsp;Tambah Produk Lain
                    </button>

                    <hr style="margin: 20px 0 12px;">

                    <div class="form-group">
                        <label class="control-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3"
                                  placeholder="Catatan kunjungan (opsional)...">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Foto Kunjungan</label>
                        <input type="file" name="foto_kunjungan" class="form-control"
                               accept="image/jpeg,image/png,image/jpg">
                        <p class="help-block" style="font-size:11px;">
                            <i class="fa fa-info-circle"></i> Opsional. Maks. 2MB (jpg/png).
                        </p>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">
                        <i class="fa fa-save"></i> Simpan Kunjungan
                    </button>
                    <a href="{{ route('kunjungan.index') }}" class="btn btn-default btn-flat" style="margin-left:6px;">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const PRODUK_DATA = {!! json_encode($produk->map(function($p) {
    return ['id' => $p->id_produk, 'nama' => $p->nama_produk, 'stok' => $p->stok, 'harga' => $p->harga_jual];
})) !!};

let rowCount = 0;

function rp(n) {
    return 'Rp ' + parseInt(n || 0).toLocaleString('id-ID');
}

function hl(text, q) {
    if (!q) return text;
    let re = new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
    return String(text).replace(re, '<mark>$1</mark>');
}

function createRow(idx) {
    return `
    <div class="produk-card" id="row-${idx}" data-idx="${idx}">
        <div class="produk-card-header">
            <div class="produk-card-title">
                <span class="badge-num" id="num-${idx}">${idx + 1}</span>
                Produk
            </div>
            <button type="button" class="btn-remove-row" onclick="removeRow(${idx})">
                <i class="fa fa-times-circle"></i> Hapus
            </button>
        </div>

        <input type="hidden" name="produk[${idx}][produk_id]" id="pid-${idx}">

        {{-- ① Search bar --}}
        <div class="produk-search-wrap">
            <i class="fa fa-search ico-search"></i>
            <input type="text"
                   class="produk-search-input"
                   id="ac-${idx}"
                   placeholder="Ketik nama produk untuk mencari..."
                   autocomplete="off"
                   data-idx="${idx}">
            <button type="button" class="btn-clear-input" id="clr-${idx}"
                    onclick="clearRow(${idx})" title="Hapus pilihan">&times;</button>
        </div>

        {{-- ② Hasil pencarian (inline panel) --}}
        <div class="search-panel" id="dd-${idx}"></div>

        {{-- ③ Produk terpilih --}}
        <div class="selected-produk-box" id="sel-${idx}">
            <div class="sel-icon"><i class="fa fa-check"></i></div>
            <div class="sel-body">
                <div class="sel-name" id="sel-name-${idx}"></div>
                <div class="sel-meta" id="sel-meta-${idx}"></div>
            </div>
            <button type="button" class="btn-ganti" onclick="clearRow(${idx})">
                <i class="fa fa-pencil"></i> Ganti Produk
            </button>
        </div>

        {{-- ④ Qty stepper --}}
        <div class="qty-row" id="qty-row-${idx}">
            <label>Jumlah (Qty) <span class="text-danger">*</span></label>
            <div class="qty-stepper">
                <button type="button" onclick="stepQty(${idx}, -1)">−</button>
                <input type="number" name="produk[${idx}][qty]"
                       id="qty-${idx}" min="1" value="1">
                <button type="button" onclick="stepQty(${idx}, 1)">+</button>
            </div>
            <span class="qty-stok-info" id="stok-info-${idx}"></span>
        </div>
    </div>`;
}

function stepQty(idx, delta) {
    let el  = document.getElementById(`qty-${idx}`);
    let val = parseInt(el.value) || 1;
    let max = parseInt(el.max) || 9999;
    el.value = Math.max(1, Math.min(val + delta, max));
}

function addProdukRow() {
    let idx = rowCount++;
    document.getElementById('produk-container').insertAdjacentHTML('beforeend', createRow(idx));
    initRowSearch(idx);
    document.getElementById(`ac-${idx}`).focus();
    updateCardNumbers();
}

function removeRow(idx) {
    let cards = document.querySelectorAll('.produk-card');
    if (cards.length <= 1) { alert('Minimal harus ada 1 produk!'); return; }
    document.getElementById(`row-${idx}`)?.remove();
    updateCardNumbers();
}

function updateCardNumbers() {
    document.querySelectorAll('.produk-card').forEach(function(card, i) {
        let b = card.querySelector('.badge-num');
        if (b) b.textContent = i + 1;
    });
}

function clearRow(idx) {
    document.getElementById(`pid-${idx}`).value = '';
    let ac = document.getElementById(`ac-${idx}`);
    ac.value = '';
    ac.classList.remove('selected');
    document.getElementById(`clr-${idx}`).style.display = 'none';
    document.getElementById(`sel-${idx}`).classList.remove('show');
    document.getElementById(`qty-row-${idx}`).classList.remove('show');
    document.getElementById(`dd-${idx}`).classList.remove('open');
    ac.focus();
}

function initRowSearch(idx) {
    let input = document.getElementById(`ac-${idx}`);
    let panel = document.getElementById(`dd-${idx}`);
    let active = -1;

    function render(q) {
        q = (q || '').trim();
        if (!q) { panel.classList.remove('open'); return; }

        let list  = PRODUK_DATA.filter(p => p.nama.toLowerCase().includes(q.toLowerCase()));
        let shown = list.slice(0, 40);
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
                     onclick="pickItem(${idx}, this)">
                    <div class="sp-item-icon"><i class="fa fa-box"></i></div>
                    <div class="sp-item-body">
                        <div class="sp-item-name">${hl(p.nama, q)}</div>
                        <div class="sp-item-price">${rp(p.harga)}</div>
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
        active = -1;
    }

    input.addEventListener('input', function() {
        document.getElementById(`pid-${idx}`).value = '';
        input.classList.remove('selected');
        document.getElementById(`clr-${idx}`).style.display = 'none';
        document.getElementById(`sel-${idx}`).classList.remove('show');
        document.getElementById(`qty-row-${idx}`).classList.remove('show');
        render(this.value);
    });

    input.addEventListener('keydown', function(e) {
        let items = panel.querySelectorAll('.sp-item');
        if (!items.length) return;
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            active = Math.min(active + 1, items.length - 1);
            items.forEach((el, i) => el.classList.toggle('active', i === active));
            items[active]?.scrollIntoView({ block: 'nearest' });
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            active = Math.max(active - 1, 0);
            items.forEach((el, i) => el.classList.toggle('active', i === active));
            items[active]?.scrollIntoView({ block: 'nearest' });
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (active >= 0) items[active].click();
        } else if (e.key === 'Escape') {
            panel.classList.remove('open');
        }
    });
}

function pickItem(idx, el) {
    let id    = el.dataset.id;
    let nama  = el.dataset.nama;
    let stok  = el.dataset.stok;
    let harga = el.dataset.harga;

    document.getElementById(`pid-${idx}`).value = id;

    let ac = document.getElementById(`ac-${idx}`);
    ac.value = nama;
    ac.classList.add('selected');
    document.getElementById(`clr-${idx}`).style.display = 'block';
    document.getElementById(`dd-${idx}`).classList.remove('open');

    document.getElementById(`sel-name-${idx}`).textContent = nama;
    document.getElementById(`sel-meta-${idx}`).textContent = rp(harga) + '  •  Stok tersedia: ' + stok;
    document.getElementById(`sel-${idx}`).classList.add('show');

    let qtyEl = document.getElementById(`qty-${idx}`);
    qtyEl.max = stok;
    if (!qtyEl.value || parseInt(qtyEl.value) < 1) qtyEl.value = 1;
    document.getElementById(`stok-info-${idx}`).textContent = '(max ' + stok + ')';
    document.getElementById(`qty-row-${idx}`).classList.add('show');
    qtyEl.focus();
}

document.getElementById('form-kunjungan').addEventListener('submit', function(e) {
    let cards = document.querySelectorAll('.produk-card');
    let map   = {};
    let ok    = true;

    cards.forEach(function(card) {
        let idx = card.dataset.idx;
        let pid = document.getElementById(`pid-${idx}`)?.value;
        let qty = parseInt(document.getElementById(`qty-${idx}`)?.value) || 0;
        let ac  = document.getElementById(`ac-${idx}`);
        if (!pid) { ac.style.borderColor = '#f87171'; ok = false; return; }
        if (qty < 1) { ok = false; return; }
        map[pid] = (map[pid] || 0) + qty;
    });

    if (!ok) {
        e.preventDefault();
        alert('Pastikan semua produk sudah dipilih dan qty minimal 1!');
        return;
    }

    let hasDup = Object.keys(map).length < cards.length;
    if (hasDup) {
        e.preventDefault();
        if (!confirm('Ada produk yang sama di beberapa baris.\nQty akan digabungkan otomatis. Lanjutkan?')) return;
        document.querySelectorAll('.produk-card').forEach(c => c.remove());
        let i = 0;
        for (let pid in map) {
            let fi = document.createElement('input');
            let qi = document.createElement('input');
            fi.type = 'hidden'; fi.name = `produk[${i}][produk_id]`; fi.value = pid;
            qi.type = 'hidden'; qi.name = `produk[${i}][qty]`;       qi.value = map[pid];
            document.getElementById('produk-container').appendChild(fi);
            document.getElementById('produk-container').appendChild(qi);
            i++;
        }
        document.getElementById('form-kunjungan').submit();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    addProdukRow();
});
</script>
@endpush
