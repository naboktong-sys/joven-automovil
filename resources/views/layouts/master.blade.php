<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $setting->nama_perusahaan }} | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="icon" href="{{ url($setting->path_logo) }}" type="image/png">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('/AdminLTE-2/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/AdminLTE-2/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/AdminLTE-2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    
    @stack('css')
</head>
<body class="hold-transition sidebar-mini skin-blue">
    <div class="wrapper">
        @includeIf('layouts.header')
        @includeIf('layouts.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content-header">
                <h1>@yield('title')</h1>
                <ol class="breadcrumb">
                    @section('breadcrumb')
                        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    @show
                </ol>
            </section>

            <section class="content">
                @yield('content')
            </section>
        </div>

        @includeIf('layouts.footer')
    </div>

    <!-- Overlay drawer sidebar (tablet / HP) -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <!-- jQuery 3 -->
    <script src="{{ asset('AdminLTE-2/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('AdminLTE-2/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Moment -->
    <script src="{{ asset('AdminLTE-2/bower_components/moment/min/moment.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables -->
    <script src="{{ asset('AdminLTE-2/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE-2/dist/js/adminlte.min.js') }}"></script>
    <!-- Validator -->
    <script src="{{ asset('js/validator.min.js') }}"></script>
    <script>
        function preview(selector, temporaryFile, width = 200) {
            $(selector).empty();
            $(selector).append(`<img src="${window.URL.createObjectURL(temporaryFile)}" width="${width}">`);
        }

        $(document).ready(function() {

        // Fix 1: Cleanup backdrop sebelum modal dibuka
        $(document).on('show.bs.modal', '.modal', function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '0');
        });

        // Fix 2: Pastikan hanya 1 backdrop setelah modal dibuka
        $(document).on('shown.bs.modal', '.modal', function() {
            if ($('.modal-backdrop').length > 1) {
                $('.modal-backdrop').not(':first').remove();
            }
        });

        // Fix 3: Bersihkan backdrop setelah modal ditutup
        $(document).on('hidden.bs.modal', '.modal', function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '0');
        });

        // Fix 4: Cleanup saat halaman dimuat
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '0');

        console.log('✅ Modal Fix Active');
    });

    </script>

    @yield('page-content')

    @stack('scripts')
    
    <script>
    // Sidebar responsif: desktop = collapse (mini), tablet/HP = drawer
    (function () {
        var BREAKPOINT = 992;
        var $body = $('body');

        function isDrawerMode() {
            return window.innerWidth < BREAKPOINT;
        }

        function closeDrawer() {
            $body.removeClass('sidebar-open');
        }

        function syncMode() {
            if (isDrawerMode()) {
                $body.removeClass('sidebar-collapse');
            } else {
                closeDrawer();
            }
        }

        $(document).ready(function () {
            // Bersihkan style inline dari AdminLTE agar tidak menimpa CSS responsif
            $('.main-sidebar, .main-header').removeAttr('style');
            $('.content-wrapper').css('min-height', '');

            syncMode();

            $('#sidebar-toggle').on('click', function (e) {
                e.preventDefault();
                if (isDrawerMode()) {
                    $body.toggleClass('sidebar-open');
                } else {
                    $body.toggleClass('sidebar-collapse');
                }
            });

            // Tutup drawer: klik overlay, pilih menu, atau tombol Esc
            $('#sidebar-overlay').on('click', closeDrawer);
            $('.main-sidebar .menu-link').on('click', function () {
                if (isDrawerMode()) { closeDrawer(); }
            });
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') { closeDrawer(); }
            });

            var resizeTimer;
            $(window).on('resize orientationchange', function () {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(syncMode, 100);
            });
        });
    })();
    </script>
</body>
</html>
