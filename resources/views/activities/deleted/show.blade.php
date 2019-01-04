@extends('layouts.app')

@section('content')

    @include ("header.modal")

    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>{{ ucfirst($classItems['header']) }}</li>
            <li class="active">Deleted {{ ucfirst($classItems['header']) }}</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Deleted {{ ucfirst($classItems['header']) }}</div>
                    <div class="panel-body">
                        @include ("activities.deleted.{$classItems['view']}",['linkCollection' => $linkCollection])
                        {{ $deletedItems or '' && $deletedItems->links() }}
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

        $(document).on("click", ".link", function(e){

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

@endsection