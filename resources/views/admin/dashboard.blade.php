@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
@endsection

@section('content')
<!-- Welcome Section -->
<div class="welcome-banner">
    <div class="welcome-content">
        <div class="welcome-text">
            <h1 class="welcome-title">Welcome Back, {{ auth()->user()->name }}! 👋</h1>
            <p class="welcome-subtitle">Here's what's happening with your business today</p>
        </div>
        <div class="welcome-date">
            <i class="fa fa-calendar"></i>
            <span id="current-date"></span>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row stats-row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="stat-card stat-card-primary">
            <div class="stat-icon">
                <div class="icon-wrapper">
                    <i class="fa fa-cube"></i>
                </div>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $kategori }}</div>
                <div class="stat-label">Total Kategori</div>
                <div class="stat-trend positive">
                    <i class="fa fa-arrow-up"></i>
                    <span>Active</span>
                </div>
            </div>
            <br><br>
            <a href="{{ route('kategori.index') }}" class="stat-footer">
                <span>View Details</span>
                <i class="fa fa-arrow-right"></i>
            </a>
            <div class="stat-bg-icon">
                <i class="fa fa-cube"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="stat-card stat-card-success">
            <div class="stat-icon">
                <div class="icon-wrapper">
                    <i class="fa fa-cubes"></i>
                </div>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $produk }}</div>
                <div class="stat-label">Total Produk</div>
                <div class="stat-trend positive">
                    <i class="fa fa-arrow-up"></i>
                    <span>In Stock</span>
                </div>
            </div>
            <br><br>
            <a href="{{ route('produk.index') }}" class="stat-footer">
                <span>View Details</span>
                <i class="fa fa-arrow-right"></i>
            </a>
            <div class="stat-bg-icon">
                <i class="fa fa-cubes"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="stat-card stat-card-info">
            <div class="stat-icon">
                <div class="icon-wrapper">
                    <i class="fa fa-building"></i>
                </div>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $toko ?? 0 }}</div>
                <div class="stat-label">Total Toko</div>
                <div class="stat-trend positive">
                    <i class="fa fa-users"></i>
                    <span>Registered</span>
                </div>
            </div>
            <br><br>
            <a href="{{ route('toko.index') }}" class="stat-footer">
                <span>View Details</span>
                <i class="fa fa-arrow-right"></i>
            </a>
            <div class="stat-bg-icon">
                <i class="fa fa-building"></i>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Update current date
function updateDate() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const dateString = now.toLocaleDateString('id-ID', options);
    const dateElement = document.getElementById('current-date');
    if (dateElement) {
        dateElement.textContent = dateString;
    }
}
updateDate();
</script>
@endpush
