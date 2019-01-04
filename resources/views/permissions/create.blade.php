@extends('layouts.app')

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Permissions</li>
            <li class="active">Add Permission</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Permission</div>
                <div class="panel-body">
                    <div class="col-md-8 col-md-offset-2">
                    <form class="form-horizontal" role="form" action="{{ url('/permissions') }}" method="post">
                        {{ csrf_field() }}
                        <fieldset>
                        @include('permissions.form',['submitButtonText' => 'Add Permission'])
                        </fieldset>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection