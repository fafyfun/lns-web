@extends('layouts.app')

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Brands</li>
            <li class="active">Edit Brand</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div>
                        Edit Brand
                    </div>
                    <div>
                        <a style="margin-top: -40px;" href="javascript:history.back()" class="btn btn-primary btn-sm pull-right">Back</a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-8 col-md-offset-2">
                    <form class="form-horizontal" role="form" action='{{ url("/brands/$brand->id") }}' method="post">
                        {{ method_field('PUT') }}   {{ csrf_field() }}
                        @include('brands.form',['submitButtonText' => 'Update Brand'])
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection