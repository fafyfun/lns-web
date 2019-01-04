@extends('layouts.app1')

@section('content')
    <section class="content-header">

    </section>
    @if(Auth::User()->can('CanAddUsers'))
    <section class="content">
        <form  class="form-horizontal" action="{{ url('/register') }}" method="post">
            {{ csrf_field() }}

            <div class="col-md-12">
                <div class="box box-info box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">User Registration</h3>
                    </div>
                    <div class="box-body">

                        <div class="form-group">

                            <div class="{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-2 control-label">Name</label>

                                <div class="col-sm-4">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>

                            <div class="{{ $errors->has('phonenumber') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-2 control-label">Phone No</label>

                                <div class="col-sm-4">
                                    <input id="phonenumber" type="text" class="form-control" name="phonenumber" value="{{ old('phonenumber') }}" required >

                                    @if ($errors->has('phonenumber'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phonenumber') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="form-group">

                            <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-sm-2 control-label">E-Mail Address</label>

                                <div class="col-sm-4">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-sm-2 control-label">Password</label>

                                <div class="col-sm-4">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            </div>

                        <div class="form-group">

                            <div class="{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-sm-2 control-label">Confirm Password</label>

                                <div class="col-sm-4">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="{{ $errors->has('status') ? ' has-error' : '' }}">
                                <label for="status" class="col-sm-2 control-label">Status</label>

                                <div class="col-sm-4">
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

                            </div>

                        <div class="form-group">

                            <div class="{{ $errors->has('faculty') ? ' has-error' : '' }}">
                                <label for="status" class="col-sm-2 control-label">Faculty</label>

                                <div class="col-sm-4">
                                    @foreach ($faculties as $faculty)
                                        <div><input type="checkbox" id="faculty" name="faculty[{{ $faculty->id }}]" value="{{ $faculty->id }}" @if(array_key_exists($faculty->id, old('faculty', []))) checked @else @if(isset($facultyId) && $facultyId==$faculty->id) checked @endif @endif >{{ $faculty->name }}</div>
                                    @endforeach

                                    @if ($errors->has('faculty'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('faculty') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="{{ $errors->has('course') ? ' has-error' : '' }}">
                                <label for="status" class="col-sm-2 control-label">Course</label>

                                <div class="col-sm-4">
                                    @foreach ($courses as $course)
                                        <div><input type="checkbox" id="course" name="course[{{ $course->id }}]" value="{{ $course->id }}" @if(array_key_exists($course->id, old('course', []))) checked @else @if(isset($courseId) && $courseId==$course->id) checked @endif @endif >{{ $course->name }}</div>
                                    @endforeach

                                    @if ($errors->has('course'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('course') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            </div>

                        <div class="form-group">

                            <div class="{{ $errors->has('department') ? ' has-error' : '' }}">
                                <label for="status" class="col-sm-2 control-label">Department</label>

                                <div class="col-sm-4">
                                    @foreach ($departments as $department)
                                        <div><input type="checkbox" id="department" name="department[{{ $department->id }}]" value="{{ $department->id }}" @if(array_key_exists($department->id, old('department', []))) checked @else @if(isset($departmentId) && $departmentId==$department->id) checked @endif @endif >{{ $department->name }}</div>
                                    @endforeach

                                    @if ($errors->has('department'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('department') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="{{ $errors->has('role') ? ' has-error' : '' }}">
                                <label for="status" class="col-sm-2 control-label">Role</label>

                                <div class="col-sm-4">
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

                            </div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </form>


    </section>
@endif
@endsection