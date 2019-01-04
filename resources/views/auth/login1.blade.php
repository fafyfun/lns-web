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
    <div class="login-logo">
    <!-- <a href="<?php //echo $url ?>/index2.html"> --><b> {{ config('app.name', 'Laravel') }}</b><!-- </a> -->
    </div>
    <span class="error"><?php //if(isset($invalid_data)){ echo $invalid_data; } ?></span>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="{{ url('/login') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input type="email" id="email" name="email" class="form-control" placeholder="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif
                <span class="error"><?php //if($errors->has('username')) { echo $errors->first('username'); }  ?></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                @if ($errors->has('password'))
                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            <!-- <span class="error"><?php //if($errors->has('password')) { echo $errors->first('password');  }  ?></span> -->
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <!--  <div class="col-xs-8">
                   <div class="checkbox icheck">
                     <label>
                       <input type="checkbox"> Remember Me
                     </label>
                   </div>
                 </div> -->
                <!-- /.col -->
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>

                        <a class="btn btn-link" href="{{ url('/password/reset') }}">
                            Forgot Your Password?
                        </a>
                    </div>
                </div>
                <!-- <div class="col-xs-4">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div> -->
                <!-- /.col -->
            </div>
        </form>

        {{--<span><b>Powered By</b> <br>Department Of Information Communication Technology</span>--}}
        {{--<span><br>Faculty Of Technology</span>--}}
        {{--<span><br>SEUSL</span>--}}

    </div>

</div>
<footer class="pull-right hidden-xs">
    <strong>Copyright &copy;Department Of Information Communication Technology
        <br>Faculty Of Technology
        <br>SEUSL
    </strong><br>All rights
    reserved.
</footer>



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