<header class="main-header">
    <!-- Logo -->
    <a href=# class="logo">
        @php
            $words = explode(' ', $setting->nama_perusahaan);
            $word  = '';
            foreach ($words as $w) {
                $word .= $w[0];
            }
        @endphp
        <span class="logo-lg">
            <b>{{ $setting->nama_perusahaan }}</b>
        </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <i class="toggle-icon"></i>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="user-avatar">
                            <img src="{{ url(auth()->user()->foto ?: '/img/user.svg') }}" class="user-image img-profil" alt="User Image">
                            <span class="status-indicator"></span>
                        </div>
                        <span class="user-name hidden-xs">{{ auth()->user()->name }}</span>
                        <i class="dropdown-arrow"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <div class="user-avatar-large">
                                <img src="{{ url(auth()->user()->foto ?: '/img/user.svg') }}" class="img-circle img-profil" alt="User Image">
                                <span class="status-indicator-large"></span>
                            </div>
                            <p class="user-info">
                                <span class="user-info-name">{{ auth()->user()->name }}</span>
                                <span class="user-info-email">{{ auth()->user()->email }}</span>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="footer-buttons">
                                <a href="{{ route('user.profil') }}" class="btn btn-profile">
                                    <i class="icon-user"></i>
                                    <span>Profil</span>
                                </a>
                                <a href="#" class="btn btn-logout" onclick="$('#logout-form').submit()">
                                    <i class="icon-logout"></i>
                                    <span>Keluar</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
    @csrf
</form>
