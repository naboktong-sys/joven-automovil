@extends('layouts.master')

@section('title')
    Histori Toko
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Histori Toko</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-history"></i>
                    Histori Kunjungan Toko
                </h3>
            </div>
            <div class="box-body">
                <p>Halaman histori kunjungan semua toko.</p>
                <p>Untuk melihat detail histori per toko, silakan klik tombol "Histori" pada halaman <a href="{{ route('toko.index') }}">Toko Langganan</a>.</p>

                <br>
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('toko.index') }}" class="btn btn-primary btn-block">
                            <i class="fa fa-store"></i> Lihat Daftar Toko
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('kunjungan.index') }}" class="btn btn-info btn-block">
                            <i class="fa fa-clipboard-list"></i> Lihat Daftar Kunjungan
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('kunjungan.create') }}" class="btn btn-success btn-block">
                            <i class="fa fa-plus-circle"></i> Tambah Kunjungan Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
