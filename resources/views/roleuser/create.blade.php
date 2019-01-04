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
                    <h3 class="box-title">Assign Role To User</h3>
                </div>
                <form  class="form-horizontal" action="{{ url('/roleuser') }}" method="post">
                    {{ csrf_field() }}

                    @include('roleuser.form',['submitButtonText' => 'Assign'])

                </form>
            </div>
        </div>




    </section>

    <script>
        $("#error").fadeOut(5000);
    </script>

@endsection