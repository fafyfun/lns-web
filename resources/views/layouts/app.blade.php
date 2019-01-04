<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ url('/') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/bootstrap-table.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/styles.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/bootstrap-datetimepicker.css" rel="stylesheet">
    {{--<script type="text/javascript" src="{{ url('/') }}/js/jquery-1.11.1.min.js"></script>--}}
    <script type="text/javascript" src="{{ url('/') }}/js/jquery.min.js"></script>
    <script src="{{ url('/') }}/js/typeahead.js"></script>
    <script src="{{ url('/') }}/js/moment-with-locales.js"></script>
    <script src="{{ url('/') }}/js/bootstrap-datetimepicker.js"></script>
    <!--Icons-->


    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    {{--<![endif]-->--}}

</head>

<body>
@include('header.header')
@include('sidebar.sidebar')


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    @yield('content')
</div><!--/.main-->


<script src="{{ url('/') }}/js/bootstrap.min.js"></script>
<script src="{{ url('/') }}/js/chart.min.js"></script>
<script src="{{ url('/') }}/js/chart-data.js"></script>
<script src="{{ url('/') }}/js/easypiechart.js"></script>
<script src="{{ url('/') }}/js/easypiechart-data.js"></script>
<script src="{{ url('/') }}/js/bootstrap-table.js"></script>
<script src="{{ url('/') }}/js/lumino.glyphs.js"></script>


<script>
    !function ($) {
        $(document).on("click","ul.nav li.parent > a > span.icon", function(){
            $(this).find('em:first').toggleClass("glyphicon-minus");
        });
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
        if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function () {
        if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
    })
</script>
</body>

</html>
