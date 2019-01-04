@extends('layouts.app')

@section('content')

    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Permissions</li>
            <li class="active">Edit Permission</li>
        </ol>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div>
                        Edit Permission
                    </div>
                    <div>
                        <a style="margin-top: -40px;" href="javascript:history.back()" class="btn btn-primary btn-sm pull-right">Back</a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-8 col-md-offset-2">
                    <form class="form-horizontal" role="form" action='{{ url("/permissions/$permission->id") }}' method="post">
                        {{ method_field('PUT') }}   {{ csrf_field() }}
                        <fieldset>
                        @include('permissions.form',['submitButtonText' => 'Update Permission'])
                            </fieldset>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#error").fadeOut(5000);
    </script>

@endsection