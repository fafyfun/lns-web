@extends('layouts.app1')

@section('content')

    <section class="content-header">
        @include ("header.modal")
    </section>

    <section class="content">

        <div class="col-md-3">
            <div class="box box-info box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Deleted {{ $classItems['header'] }}</h3>
                </div>

                @include ("activities.deleted.{$classItems['view']}",['linkCollection' => $linkCollection])

                    {{ $deletedItems or '' && $deletedItems->links() }}


            </div>
        </div>

    </section>

    <script>



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.link').click(function(e){
            //alert('hi');
            e.preventDefault();
            var url = $(this).attr('href');

            $.ajax({
                url: url,
                type: "GET",
                dataType: 'html',
                success: function (result){

                    console.log(result);

                    $('.list-group').html(result);
                    $("#myModal").modal('show');


                },
                error:function(){
                    alert("error!!!!");
                }
            });
        });

    </script>

@stop

