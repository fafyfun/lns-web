@extends('layouts.app')

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Categories</li>
            <li class="active">Add Category</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Category</div>
                    <div class="panel-body">
                        <div class="col-md-8 col-md-offset-2">
                        <form class="form-horizontal" role="form" action="{{ url('/categories') }}" method="post">
                            {{ csrf_field() }}
                            <fieldset>
                            @include('categories.form',['submitButtonText' => 'Add Category'])
                            </fieldset>
                        </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>

@endsection