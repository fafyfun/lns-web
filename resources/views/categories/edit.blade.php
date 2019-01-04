@extends('layouts.app')

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Categories</li>
            <li class="active">Edit Category</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div>
                        Edit Category
                    </div>
                    <div>
                        <a style="margin-top: -40px;" href="javascript:history.back()" class="btn btn-primary btn-sm pull-right">Back</a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-8 col-md-offset-2">
                    <form class="form-horizontal" role="form" action='{{ url("/categories/$category->id") }}' method="post">
                        {{ method_field('PUT') }}   {{ csrf_field() }}
                        <fieldset>
                        @include('categories.form',['submitButtonText' => 'Update Category'])
                        </fieldset>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection