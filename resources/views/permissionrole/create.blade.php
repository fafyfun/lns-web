@extends('layouts.app')

@section('content')

    <div class="row" xmlns="http://www.w3.org/1999/html">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Permission Role</li>
            <li class="active">Assign Permission</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Assign Permission</div>
                <div class="panel-body">
                    <div class="col-md-8 col-md-offset-2">
                    <form class="form-horizontal" role="form" action="{{ url('/permissionrole') }}" method="post">
                        {{ csrf_field() }}
                        <fieldset>
                        @include('permissionrole.form',['submitButtonText' => 'Assign'])
                       </fieldset>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on("change", "#selectAll", function () {
            if(this.checked) {

                $(".checkbox1").prop('checked',true);

            }
            if(!this.checked){

                $(".checkbox1").prop('checked',false);

            }


        });
        $("#error").fadeOut(5000);

    </script>

@endsection