<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="user-panel-avatar">
                <img src="{{ url(auth()->user()->foto ?: '/img/user.svg') }}" class="img-circle img-profil" alt="User Image">
                <span class="user-status-badge"></span>
            </div>
            <div class="user-panel-info">
                <p class="user-panel-name">{{ auth()->user()->name }}</p>
                <div class="user-panel-status">
                    <span class="status-dot"></span>
                    <span class="status-text">Online</span>
                </div>
            </div>
        </div>

        <!-- sidebar menu -->
        <ul class="sidebar-menu" data-widget="tree">

            <!-- ============================================ -->
            <!-- DASHBOARD -->
            <!-- ============================================ -->
            <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <i class="fa fa-dashboard menu-icon"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <!-- ============================================ -->
            <!-- MASTER DATA -->
            <!-- ============================================ -->
            <li class="header">
                <span class="header-line"></span>
                <span class="header-text">MASTER DATA</span>
                <span class="header-line"></span>
            </li>

            <li class="menu-item {{ request()->is('kategori*') ? 'active' : '' }}">
                <a href="{{ route('kategori.index') }}" class="menu-link">
                    <i class="fa fa-cube menu-icon"></i>
                    <span class="menu-text">Kategori Produk</span>
                </a>
            </li>

            <li class="menu-item {{ request()->is('produk*') ? 'active' : '' }}">
                <a href="{{ route('produk.index') }}" class="menu-link">
                    <i class="fa fa-cubes menu-icon"></i>
                    <span class="menu-text">Produk Onderdil</span>
                </a>
            </li>

            <li class="menu-item {{ request()->is('katalog*') ? 'active' : '' }}">
                <a href="{{ route('katalog.index') }}" class="menu-link">
                    <i class="fa fa-book menu-icon"></i>
                    <span class="menu-text">Katalog Produk</span>
                </a>
            </li>

            <li class="menu-item {{ request()->is('toko*') ? 'active' : '' }}">
                <a href="{{ route('toko.index') }}" class="menu-link">
                    <i class="fa fa-building menu-icon"></i>
                    <span class="menu-text">Toko Langganan</span>
                </a>
            </li>

            <!-- ============================================ -->
            <!-- KUNJUNGAN SALES -->
            <!-- ============================================ -->
            <li class="header">
                <span class="header-line"></span>
                <span class="header-text">KUNJUNGAN SALES</span>
                <span class="header-line"></span>
            </li>

            <li class="menu-item highlight {{ request()->is('kunjungan/create') ? 'active' : '' }}">
                <a href="{{ route('kunjungan.create') }}" class="menu-link">
                    <i class="fa fa-plus-circle menu-icon"></i>
                    <span class="menu-text">Tambah Kunjungan</span>
                </a>
            </li>

            <li class="menu-item {{ request()->is('kunjungan') || request()->is('kunjungan/index') ? 'active' : '' }}">
                <a href="{{ route('kunjungan.index') }}" class="menu-link">
                    <i class="fa fa-list-alt menu-icon"></i>
                    <span class="menu-text">Daftar Kunjungan</span>
                </a>
            </li>

            <li class="menu-item {{ request()->is('histori*') ? 'active' : '' }}">
                <a href="{{ route('histori.index') }}" class="menu-link">
                    <i class="fa fa-history menu-icon"></i>
                    <span class="menu-text">Histori Toko</span>
                </a>
            </li>

            <!-- ============================================ -->
            <!-- SYSTEM -->
            <!-- ============================================ -->
            <li class="header">
                <span class="header-line"></span>
                <span class="header-text">SYSTEM</span>
                <span class="header-line"></span>
            </li>

            @if (auth()->user()->isAdmin())
            <li class="menu-item {{ request()->is('user*') && !request()->is('user/profil') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class="menu-link">
                    <i class="fa fa-users menu-icon"></i>
                    <span class="menu-text">Manajemen User</span>
                </a>
            </li>

            <li class="menu-item {{ request()->is('setting*') ? 'active' : '' }}">
                <a href="{{ route('setting.index') }}" class="menu-link">
                    <i class="fa fa-cogs menu-icon"></i>
                    <span class="menu-text">Pengaturan</span>
                </a>
            </li>
            @endif

            <li class="menu-item {{ request()->is('profil') || request()->is('user/profil') ? 'active' : '' }}">
                <a href="{{ route('user.profil') }}" class="menu-link">
                    <i class="fa fa-user-circle menu-icon"></i>
                    <span class="menu-text">Profil Saya</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
