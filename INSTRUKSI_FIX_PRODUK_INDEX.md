# INSTRUKSI FIX resources/views/produk/index.blade.php

## HAPUS BAGIAN INI:

### 1. Baris 33-44 (Filter Outlet) - HAPUS SELURUHNYA:
```blade
@if(auth()->user()->level == 1)
<div class="filter-outlet-wrapper" style="display: inline-block; margin-right: 10px; vertical-align: middle;">
    <label for="outlet_filter_produk" style="margin-right: 5px; font-weight: 500; display: inline-block;">
        <i class="fa fa-filter"></i> Filter Outlet:
    </label>
    <select id="outlet_filter_produk" class="form-control" style="width: 200px; display: inline-block;">
        <option value="all">Semua Outlet</option>
        @foreach($outlet as $id => $nama)
            <option value="{{ $id }}">{{ $nama }}</option>
        @endforeach
    </select>
</div>
@endif
```

### 2. Baris 96-101 (Kolom Outlet di Header Table) - HAPUS:
```blade
@if(auth()->user()->level == 1)
<th width="12%">
    <div class="th-content">
        <i class="fa fa-home"></i>
        Outlet
    </div>
</th>
@endif
```

### 3. Baris 138-141 (JavaScript columns.push outlet) - HAPUS:
```javascript
// Tambah kolom outlet jika admin
@if(auth()->user()->level == 1)
columns.push({data: 'outlet'});
@endif
```

### 4. Baris 171-176 (Event handler filter outlet) - HAPUS:
```javascript
// Event handler untuk filter outlet (hanya untuk admin)
@if(auth()->user()->level == 1)
$('#outlet_filter_produk').on('change', function() {
    table.ajax.reload();
});
@endif
```

### 5. Baris 156-160 (Ajax data filter outlet) - HAPUS:
Di bagian ajax DataTables, hapus:
```javascript
ajax: {
    url: '{{ route('produk.data') }}',
    data: function(d) {
        @if(auth()->user()->level == 1)
        d.outlet_filter = $('#outlet_filter_produk').val();  // HAPUS BARIS INI
        @endif
    }
},
```

Jadi tinggal:
```javascript
ajax: {
    url: '{{ route('produk.data') }}'
},
```

### 6. Baris 261 (editForm - id_outlet field) - HAPUS:
Di fungsi editForm, hapus:
```javascript
$('#modal-form [name=id_outlet]').val(response.id_outlet);  // HAPUS BARIS INI
```

## SELESAI!

Setelah dihapus semua, struktur tabel akan jadi:
- Checkbox
- No
- Gambar
- Kode
- Nama
- Kategori
- Merk
- H. Beli
- H. Jual
- Diskon
- Stok
- Aksi

Tidak ada kolom Outlet lagi!
