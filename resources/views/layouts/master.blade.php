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
    
    <!-- Critical CSS - Force Sidebar Left -->
    <style>
        .main-sidebar { position: fixed !important; top: 0 !important; left: 0 !important; width: 250px !important; height: 100vh !important; }
        .main-header { position: fixed !important; top: 0 !important; left: 250px !important; right: 0 !important; }
        .content-wrapper { margin-left: 250px !important; margin-top: 50px !important; }
        .main-header .logo { position: fixed !important; top: 0 !important; left: 0 !important; width: 250px !important; height: 50px !important; }
        .sidebar { padding-top: 50px !important; }
    </style>

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
    // Force sidebar to left on page load
    $(document).ready(function() {
        // Remove any conflicting inline styles
        $('.main-sidebar').removeAttr('style');
        $('.main-header').removeAttr('style');
        $('.content-wrapper').removeAttr('style');
        
        // Ensure sidebar is visible
        $('body').removeClass('sidebar-collapse');
        
        console.log('✅ Sidebar positioned to left');
    });
    </script>
</body>
</html>
