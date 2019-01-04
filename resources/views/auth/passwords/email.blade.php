<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php

    // $baseurl = url();
    //      $urlget = explode("index.php",$baseurl);
    //      $url = $urlget[0];
    //echo $url;
    ?>
    <title> {{ config('app.name', 'Laravel') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ url('/') }}/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('/') }}/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('/') }}/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/') }}/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('/') }}/css/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ url('/') }}/js/html5shiv.min.js"></script>
    <script src="{{ url('/') }}/js/respond.min.js"></script>
    <![endif]-->
</head>
@if(Session::has('errormessage'))
    <!-- <div id="error" class="col-md-12 alert alert-danger alert-dismissable" style="z-index:1;position:absolute;text-align:center;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-close"></i>{{ Session::get('errormessage') }}</h4>
                  </div> -->
@endif
<body class="hold-transition login-page">
<div class="login-box">

    <span class="error"><?php //if(isset($invalid_data)){ echo $invalid_data; } ?></span>
    <!-- /.login-logo -->
    <div class="login-logo">
        <div class="panel-heading">Reset Password</div>
    </div>
    <div class="login-box-body">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
            {{ csrf_field() }}

            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">


                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email" required>
                    <input id="status" type="hidden"  name="status" value="A">
                    @if ($errors->has('email'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif

            </div>

            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">
                        Send Password Reset Link
                    </button>
                </div>
            </div>
        </form>



    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.0 -->
<script src="{{ url('/') }}/js/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ url('/') }}/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{ url('/') }}/js/icheck.min.js"></script>
<script>
    // $("#error").fadeOut(5000);
    //   $(function () {
    //     $('input').iCheck({
    //       checkboxClass: 'icheckbox_square-blue',
    //       radioClass: 'iradio_square-blue',
    //       increaseArea: '20%' // optional
    //     });
    //   });
</script>
</body>
</html>