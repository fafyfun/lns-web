@extends('layouts.app1')

@section('content')
    <section class="content-header">

        @if(Session::has('error'))
            <div id="error" class="alert alert-danger alert-dismissible" style="z-index:1;position:absolute;width: 50%;margin: 0 auto;left: 0;right: 0;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> {{ Session::get('error') }}</h4>
            </div>
        @endif

    </section>
    <section class="content">


        <div class="col-md-12">
            <div class="box box-info box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Change Password</h3>
                </div>
                <form  class="form-horizontal" action='{{ url("/changepassword") }}' method="post">
                    {{ method_field('PUT') }} {{ csrf_field() }}

                    <div class="box-body">

                        <div class="form-group{{ $errors->has('oldpassword') ? ' has-error' : '' }}">
                            <label for="password" class="col-sm-2 control-label">Old Password</label>

                            <div class="col-sm-4">
                                <input id="oldpassword" type="password" class="form-control" name="oldpassword" required>

                                @if ($errors->has('oldpassword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('oldpassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('newpassword') ? ' has-error' : '' }}">
                            <label for="password" class="col-sm-2 control-label">New Password</label>

                            <div class="col-sm-4">
                                <input id="newpassword" type="password" class="form-control" name="newpassword" required>

                                @if ($errors->has('newpassword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('newpassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-sm-2 control-label">Confirm Password</label>

                            <div class="col-sm-4">
                                <input id="newpassword_confirmation-confirm" type="password" class="form-control" name="newpassword_confirmation" required>

                                @if ($errors->has('newpassword_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('newpassword_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    Change
                                </button>
                            </div>
                        </div>


                    </div>

                </form>
            </div>
        </div>




    </section>

    <script>
        $("#error").fadeOut(5000);
    </script>

@endsection