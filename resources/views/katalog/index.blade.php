@extends('layouts.master')

@section('title')
    Katalog Produk
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Katalog Produk</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box modern-box">
            <!-- Box Header -->
            <div class="box-header">
                <div class="box-header-left">
                    <h3 class="box-title">
                        <i class="fa fa-book"></i>
                        <span>Katalog Produk Onderdil</span>
                    </h3>
                    <p class="box-subtitle">Tampilkan katalog produk untuk juragan toko</p>
                </div>
                <div class="box-header-right">
                    <button onclick="toggleView()" class="btn btn-info btn-action">
                        <i class="fa fa-th" id="view-icon"></i>
                        <span id="view-text">Grid View</span>
                    </button>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="box-body">
                <div class="filter-section">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <i class="fa fa-search"></i>
                                    Cari Produk
                                </label>
                                <input type="text" id="search-produk" class="form-control" placeholder="Nama produk...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <i class="fa fa-cube"></i>
                                    Kategori
                                </label>
                                <select id="filter-kategori" class="form-control">
                                    <option value="">Semua Kategori</option>
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <i class="fa fa-filter"></i>
                                    Stok
                                </label>
                                <select id="filter-stok" class="form-control">
                                    <option value="">Semua Stok</option>
                                    <option value="tersedia">Tersedia (> 10)</option>
                                    <option value="menipis">Stok Menipis (≤ 10)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <i class="fa fa-sort"></i>
                                    Urutkan
                                </label>
                                <select id="sort-by" class="form-control">
                                    <option value="nama_asc">Nama A-Z</option>
                                    <option value="nama_desc">Nama Z-A</option>
                                    <option value="harga_asc">Harga Terendah</option>
                                    <option value="harga_desc">Harga Tertinggi</option>
                                    <option value="stok_desc">Stok Terbanyak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button onclick="resetFilter()" class="btn btn-default">
                                <i class="fa fa-refresh"></i> Reset Filter
                            </button>
                            <span id="result-count" class="text-muted" style="margin-left: 15px;"></span>
                        </div>
                    </div>
                </div>

                <!-- Products Container -->
                <div id="products-container" class="products-grid">
                    <!-- Products will be loaded here via AJAX -->
                </div>

                <!-- Loading Spinner -->
                <div id="loading-spinner" class="text-center" style="display: none; padding: 40px;">
                    <i class="fa fa-spinner fa-spin fa-3x text-primary"></i>
                    <p style="margin-top: 15px; color: #7f8c8d;">Memuat produk...</p>
                </div>

                <!-- No Results -->
                <div id="no-results" class="text-center" style="display: none; padding: 60px 20px;">
                    <i class="fa fa-inbox fa-4x" style="color: #bdc3c7;"></i>
                    <h4 style="color: #7f8c8d; margin-top: 20px;">Tidak ada produk ditemukan</h4>
                    <p style="color: #95a5a6;">Coba ubah filter atau kata kunci pencarian Anda</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Produk -->
<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-info-circle"></i>
                    Detail Produk
                </h4>
            </div>
            <div class="modal-body" id="detail-content">
                <!-- Detail will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.filter-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 1px solid #e9ecef;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.products-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.product-card {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    border-color: #3498db;
}

.product-image {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: #f5f5f5;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.1);
}

.product-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #e74c3c;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: bold;
    text-transform: uppercase;
}

.product-badge.available {
    background: #27ae60;
}

.product-info {
    padding: 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-category {
    display: inline-block;
    background: #3498db;
    color: white;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 11px;
    font-weight: 600;
    margin-bottom: 10px;
    text-transform: uppercase;
    max-width: fit-content;
}

.product-name {
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    margin: 8px 0;
    min-height: 40px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}

.product-merk {
    font-size: 12px;
    color: #95a5a6;
    margin-bottom: 10px;
    font-style: italic;
}

.product-price {
    font-size: 20px;
    font-weight: bold;
    color: #27ae60;
    margin: 10px 0;
}

.product-discount {
    display: inline-block;
    background: #e74c3c;
    color: white;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 11px;
    margin-left: 8px;
    font-weight: 600;
}

.product-stock {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #7f8c8d;
    margin-top: auto;
    padding-top: 10px;
    border-top: 1px solid #ecf0f1;
}

.stock-indicator {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #27ae60;
}

.stock-indicator.low {
    background: #e74c3c;
}

.product-actions {
    padding: 0 15px 15px;
    display: flex;
    gap: 8px;
}

.product-actions .btn {
    flex: 1;
    font-size: 13px;
}

/* List View Styles */
.product-card-list {
    display: flex;
    flex-direction: row;
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.product-card-list:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-color: #3498db;
    transform: none;
}

.product-card-list .product-image {
    width: 150px;
    height: 150px;
    flex-shrink: 0;
}

.product-card-list .product-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 20px;
}

.product-card-list .product-name {
    font-size: 18px;
    min-height: auto;
}

.product-card-list .product-stock {
    border-top: none;
    padding-top: 5px;
}

.product-card-list .product-actions {
    padding: 20px;
    flex-direction: column;
    width: 150px;
    justify-content: center;
}

/* Result Count */
#result-count {
    font-size: 14px;
}

/* Responsive */
@media (max-width: 768px) {
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
    }

    .product-card-list {
        flex-direction: column;
    }

    .product-card-list .product-image {
        width: 100%;
        height: 200px;
    }

    .product-card-list .product-actions {
        width: 100%;
        flex-direction: row;
        padding: 15px;
    }

    .filter-section .form-group {
        margin-bottom: 10px;
    }

    .product-name {
        font-size: 14px;
        min-height: 35px;
    }

    .product-price {
        font-size: 16px;
    }
}
</style>
@endpush

@push('scripts')
<script>
let currentView = 'grid'; // grid or list
let allProducts = [];

$(document).ready(function() {
    loadProducts();

    // Event listeners
    $('#search-produk').on('keyup', debounce(filterProducts, 300));
    $('#filter-kategori').on('change', filterProducts);
    $('#filter-stok').on('change', filterProducts);
    $('#sort-by').on('change', filterProducts);
});

function loadProducts() {
    $('#loading-spinner').show();
    $('#products-container').hide();
    $('#no-results').hide();

    $.ajax({
        url: '{{ route("katalog.data") }}',
        method: 'GET',
        success: function(response) {
            allProducts = response;
            displayProducts(allProducts);
            $('#loading-spinner').hide();
        },
        error: function() {
            $('#loading-spinner').hide();
            alert('Gagal memuat produk');
        }
    });
}

function displayProducts(products) {
    const container = $('#products-container');
    container.empty();

    if (products.length === 0) {
        $('#no-results').show();
        container.hide();
        $('#result-count').text('');
        return;
    }

    container.show();
    $('#no-results').hide();
    $('#result-count').html(`<i class="fa fa-check-circle text-success"></i> Menampilkan <strong>${products.length}</strong> produk`);

    // Set view class
    container.removeClass('products-grid products-list');
    container.addClass(currentView === 'grid' ? 'products-grid' : 'products-list');

    products.forEach(product => {
        const card = createProductCard(product);
        container.append(card);
    });
}

function createProductCard(product) {
    const stockBadge = product.stok > 10 ?
        `<span class="product-badge available">Tersedia</span>` :
        product.stok > 0 ? `<span class="product-badge">Stok Menipis</span>` :
        `<span class="product-badge" style="background: #95a5a6;">Habis</span>`;

    const stockIndicator = product.stok > 10 ?
        `<span class="stock-indicator"></span>` :
        `<span class="stock-indicator low"></span>`;

    const discount = product.diskon > 0 ?
        `<span class="product-discount">-${product.diskon}%</span>` : '';

    const cardClass = currentView === 'grid' ? 'product-card' : 'product-card product-card-list';

    return `
        <div class="${cardClass}" onclick="showDetail(${product.id_produk})">
            <div class="product-image">
                <img src="${product.gambar_url}" alt="${product.nama_produk}" loading="lazy">
                ${stockBadge}
            </div>
            <div class="product-info">
                <span class="product-category"><i class="fa fa-tag"></i> ${product.kategori}</span>
                <h4 class="product-name">${product.nama_produk}</h4>
                ${product.merk ? `<p class="product-merk"><i class="fa fa-bookmark"></i> ${product.merk}</p>` : ''}
                <div class="product-price">
                    Rp ${formatUang(product.harga_jual)}
                    ${discount}
                </div>
                <div class="product-stock">
                    ${stockIndicator}
                    <span>Stok: <strong>${product.stok}</strong> unit</span>
                </div>
            </div>
            <div class="product-actions">
                <button class="btn btn-info btn-sm" onclick="event.stopPropagation(); showDetail(${product.id_produk})">
                    <i class="fa fa-eye"></i> Detail
                </button>
            </div>
        </div>
    `;
}

function filterProducts() {
    const search = $('#search-produk').val().toLowerCase();
    const kategori = $('#filter-kategori').val();
    const stok = $('#filter-stok').val();
    const sortBy = $('#sort-by').val();

    let filtered = allProducts.filter(product => {
        const matchSearch = product.nama_produk.toLowerCase().includes(search) ||
                          product.kode_produk.toLowerCase().includes(search);
        const matchKategori = kategori === '' || product.id_kategori == kategori;

        let matchStok = true;
        if (stok === 'tersedia') {
            matchStok = product.stok > 10;
        } else if (stok === 'menipis') {
            matchStok = product.stok > 0 && product.stok <= 10;
        }

        return matchSearch && matchKategori && matchStok;
    });

    // Sort
    filtered.sort((a, b) => {
        switch(sortBy) {
            case 'nama_asc':
                return a.nama_produk.localeCompare(b.nama_produk);
            case 'nama_desc':
                return b.nama_produk.localeCompare(a.nama_produk);
            case 'harga_asc':
                return a.harga_jual - b.harga_jual;
            case 'harga_desc':
                return b.harga_jual - a.harga_jual;
            case 'stok_desc':
                return b.stok - a.stok;
            default:
                return 0;
        }
    });

    displayProducts(filtered);
}

function resetFilter() {
    $('#search-produk').val('');
    $('#filter-kategori').val('');
    $('#filter-stok').val('');
    $('#sort-by').val('nama_asc');
    displayProducts(allProducts);
}

function toggleView() {
    currentView = currentView === 'grid' ? 'list' : 'grid';

    const icon = $('#view-icon');
    const text = $('#view-text');

    if (currentView === 'grid') {
        icon.removeClass('fa-list').addClass('fa-th');
        text.text('Grid View');
    } else {
        icon.removeClass('fa-th').addClass('fa-list');
        text.text('List View');
    }

    // Re-display current filtered products
    filterProducts();
}

function showDetail(id) {
    $.ajax({
        url: `{{ url('katalog/detail') }}/${id}`,
        method: 'GET',
        beforeSend: function() {
            $('#detail-content').html('<div class="text-center" style="padding: 40px;"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
            $('#modal-detail').modal('show');
        },
        success: function(product) {
            const stockBadge = product.stok > 10 ?
                '<span class="label label-success">Tersedia</span>' :
                product.stok > 0 ? '<span class="label label-warning">Stok Menipis</span>' :
                '<span class="label label-danger">Habis</span>';

            const discount = product.diskon > 0 ?
                `<span class="label label-danger">Diskon ${product.diskon}%</span>` : '';

            const content = `
                <div class="row">
                    <div class="col-md-5">
                        <img src="${product.gambar_url}" class="img-responsive" style="border-radius: 8px; border: 1px solid #ddd; width: 100%;">
                    </div>
                    <div class="col-md-7">
                        <h3 style="margin-top: 0; color: #2c3e50;">${product.nama_produk}</h3>
                        <table class="table table-striped">
                            <tr>
                                <th width="40%"><i class="fa fa-barcode"></i> Kode Produk</th>
                                <td><span class="label label-info">${product.kode_produk}</span></td>
                            </tr>
                            <tr>
                                <th><i class="fa fa-cube"></i> Kategori</th>
                                <td>${product.kategori}</td>
                            </tr>
                            ${product.merk ? `
                            <tr>
                                <th><i class="fa fa-bookmark"></i> Merk</th>
                                <td>${product.merk}</td>
                            </tr>
                            ` : ''}
                            <tr>
                                <th><i class="fa fa-money"></i> Harga</th>
                                <td>
                                    <strong style="font-size: 24px; color: #27ae60;">
                                        Rp ${formatUang(product.harga_jual)}
                                    </strong>
                                    ${discount}
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fa fa-boxes"></i> Stok</th>
                                <td><strong>${product.stok}</strong> unit ${stockBadge}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            `;

            $('#detail-content').html(content);
        },
        error: function() {
            $('#detail-content').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Gagal memuat detail produk</div>');
        }
    });
}

function formatUang(angka) {
    return new Intl.NumberFormat('id-ID').format(angka);
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>
@endpush
