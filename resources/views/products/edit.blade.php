@extends('layouts.app')

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Products</li>
            <li class="active">Edit Product</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div>
                        Edit Product
                    </div>
                    <div>
                        <a style="margin-top: -40px;" href="javascript:history.back()" class="btn btn-primary btn-sm pull-right">Back to Products</a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-8 col-md-offset-2">
                    <form class="form-horizontal" role="form" action='{{ url("/products/$product->id") }}' method="post" enctype="multipart/form-data">
                        {{ method_field('PUT') }}   {{ csrf_field() }}
                        @include('products.form',['submitButtonText' => 'Update Product'])
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection