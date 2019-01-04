@extends('layouts.app')

@section('content')
    @include ("header.content-header")
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Products</li>
            <li class="active">Manage Product</li>
        </ol>
    </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-3">
                                Manage Products
                            </div>
                            <div class="col-lg-6">

                                <form role="form" action="{{ url('/search/Product') }}" method="GET">
                                    <div class="input-group">
                                        {{--<div class="input-group-btn search-panel">--}}

                                        {{--</div>--}}
                                        <input style="margin-top: 5px;" type="text" class="form-control" id="search" name="search" placeholder="Search By Name" value="{{ $search or '' }}" >
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                        <div class="panel-body">

                            @if($products->count() > 0)

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row product-row">

                                        @foreach ($products as $product)

                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <div class="col-item">
                                                    <div class="photo">
                                                        <img src="{{ url("/images/products/$product->image") }}" class="img-responsive" alt="a" style="height: 150px;width: 200px;"/>
                                                    </div>
                                                    <div class="info">
                                                        <div class="row">
                                                            <div class="price col-md-12">
                                                                <h5>{{ $product->name }}</h5>
                                                                <h5 class="price-text-color">LKR {{ $product->unit_price }}</h5>
                                                            </div>

                                                        </div>
                                                        <div class="separator clear-left">
                                                            <p class="btn-details">
                                                                <i class="fa fa-list"></i><a href='{{ url("/products/$product->id/detail") }}' class="">More details</a></p>
                                                        </div>
                                                        <div class="clearfix">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            @endforeach

                                    </div>
                                </div>

                            </div>

                            @endif

                                {{ $products->links() }}

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


        $("#success").fadeOut(5000);
        $("#error").fadeOut(5000);

        var count=0;
        var deleteProductArray=[];



        $(document).on("change", ".checkbox1", function () {

            if(this.checked) {

                count=count+1;
                $("#trash").css("display", "block");
                //alert(this.value);
                deleteProductArray.push(JSON.parse(this.value));
                //
                console.log(deleteProductArray);
                //alert(count);
            }
            if(!this.checked){
                count=count-1;
                $("#selectAll").prop('checked',false);
                if(count==0){
                    $("#trash").css("display", "none");
                }
                var index=deleteProductArray.indexOf(this.value);
                deleteProductArray.splice(index, 1);
                console.log(deleteProductArray);
                //alert(count);

            }
        });



        $(document).on("change", "#selectAll", function () {
            if(this.checked) {
                deleteProductArray=[];
                $.each(JSON.parse(this.value), function(ky, loc) {
                    deleteProductArray.push(loc);
                });

                //allID.push(this.value);
                //console.log(allID);
                $(".checkbox1").prop('checked',true);
                count=$("[type='checkbox']:checked").length-1;
                $("#trash").css("display", "block");
                //alert(count);
                console.log(deleteProductArray);
            }
            if(!this.checked){
                deleteProductArray=[];
                if(count==0){
                    $("#trash").css("display", "none");
                }
                $(".checkbox1").prop('checked',false);
                count=count-($("[type='checkbox']:not(:checked)").length-1);
                $("#trash").css("display", "none");
                //alert(count);
                console.log(deleteProductArray);
            }


        });



        function deleteProducts(){
            $.ajax({
                url:"@php echo url('/deleteproducts') @endphp",
                type: "DELETE",
                data:{deleteProduct:deleteProductArray},
                dataType: 'json',
                success: function (result){

                    console.log(result);

                    if(result.status == 1){
                        $("#deleted").css("display", "block");
                        $("#deleted").text(result.msg);
                        $("#deleted").fadeOut(3000,function(){
                            location.reload();
                        });

                    }else{
                        $("#notdeleted").css("display", "block");
                        $("#notdeleted").text(result.msg);
                        $("#notdeleted").fadeOut(3000,function(){
                            location.reload();
                        });
                    }



                },
                error:function(result){
                    alert("error!!!!");
                    console.log(result);
                }
            });
            //return false;
        }


    </script>

@endsection