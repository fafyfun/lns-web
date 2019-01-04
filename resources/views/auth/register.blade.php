@extends('layouts.app')

@section('content')

    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Users</li>
            <li class="actve">Register</li>
        </ol>
    </div>

    {{--@if(Auth::User()->can('CanAddUsers'))--}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Registration</div>
                        <div class="panel-body">
                            <div class="col-md-8 col-md-offset-2">
                            <form class="form-horizontal" role="form" action="{{ url('/register') }}" method="post">
                                {{ csrf_field() }}
                                <fieldset>
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">

                                    <label class="col-md-4 control-label">Name</label>
                                    <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                    </div>

                                </div>

                                <div class="form-group {{ $errors->has('phonenumber') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Phone No</label>

                                    <div class="col-md-6">
                                    <input id="phonenumber" type="text" class="form-control" name="phonenumber" value="{{ old('phonenumber') }}" required >

                                    @if ($errors->has('phonenumber'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phonenumber') }}</strong>
                                    </span>
                                    @endif
                                    </div>

                                </div>

                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">


                                    <label class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                    </div>

                                </div>

                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                    </div>

                                </div>

                                <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">


                                    <label class="col-md-4 control-label">Confirm Password</label>

                                    <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                    </div>

                                </div>

                                <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Status</label>

                                    <div class="col-md-6">
                                    <select id="status" name="status" class="form-control select2">
                                        <option value='A'>Active</option>
                                        <option value='D'>Deactive</option>
                                    </select>

                                    @if ($errors->has('status'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                    </div>

                                </div>


                                <div class="form-group {{ $errors->has('role') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Role</label>

                                    <div class="col-md-6">
                                    @foreach ($roles as $role)
                                        <div><input type="checkbox" id="role" name="role[{{ $role->id }}]" value="{{ $role->id }}" @if(array_key_exists($role->id, old('role', []))) checked @else @if(isset($roleId) && $roleId==$role->id) checked @endif @endif >{{ $role->name }}</div>
                                    @endforeach

                                    @if ($errors->has('role'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                                    @endif
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" ></label>
                                    <div class="col-md-6">
                                    <button type="submit" class="btn btn-success">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        Register
                                    </button>
                                        <button type="reset" class="btn btn-danger pull-right">
                                            <span class="glyphicon glyphicon-remove-sign"></span>
                                            Clear
                                        </button>
                                    </div>

                                </div>
                                </fieldset>
                            </form>
                           </div>
                        </div>
            </div>
        </div>
    </div>


    {{--@endif--}}
@endsection