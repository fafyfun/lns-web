<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ url('/') }}/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('/') }}/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('/') }}/css/ionicons.min.css">
    {{--<link rel="stylesheet" href="{{ url('/') }}/css/dataTables.bootstrap.css">--}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/') }}/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url('/') }}/css/_all-skins.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/fade.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/datepicker3.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/bootstrap-timepicker.min.css">
    <script type="text/javascript" src="{{ url('/') }}/js/jquery.min.js"></script>
    <script src="{{ url('/') }}/js/bootstrap.min.js"></script>
    <script src="{{ url('/') }}/js/bootstrap-datepicker.js"></script>
    <script src="{{ url('/') }}/js/bootstrap-timepicker.js"></script>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>

<body class="hold-transition skin-yellow sidebar-mini fixed">
<!-- Site wrapper -->
<div class="wrapper">

    @include('header.header1')
    @include('sidebar.sidebar1')

    <div class="content-wrapper">

        @yield('content')

    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy;Department Of Information Communication Technology
            ,Faculty Of Technology
            ,SEUSL
        </strong><br>All rights
        reserved.
    </footer>


    <div class="control-sidebar-bg"></div>
</div>
<script src="{{ url('/') }}/js/jquery.slimscroll.min.js"></script>
<script src="{{ url('/') }}/js/fastclick.min.js"></script>
<script src="{{ url('/') }}/js/app.min.js"></script>
<script src="{{ url('/') }}/js/demo.js"></script>
</body>
</html>
