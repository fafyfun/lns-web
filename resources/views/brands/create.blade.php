@extends('layouts.app')

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Brands</li>
            <li class="active">Add Brand</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Brand</div>
                    <div class="panel-body">
                        <div class="col-md-8 col-md-offset-2">
                        <form class="form-horizontal" role="form" action="{{ url('/brands') }}" method="post">
                            {{ csrf_field() }}
                            <fieldset>
                            @include('brands.form',['submitButtonText' => 'Add Brand'])
                            </fieldset>
                        </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>

@endsection