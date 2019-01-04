@extends('layouts.app')

@section('content')
    @include ("header.content-header")
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Products</li>
            <li class="active">Product Detail</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Product Detail</h1>
        </div>
        <div class="col-lg-6">
            <br/>
            <a href="javascript:history.back()" class="btn btn-primary pull-right">Back</a>
        </div>
    </div>

    <div class="row">

        <div class="product-detail-2">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="wrapper">
                    <div class="row">
                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <!-- <ol class="carousel-indicators">
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            </ol> -->
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img src='{{ url("/images/products/$product->image") }}' alt="First slide">
                                </div>

                            </div>
                            <!-- <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a> -->
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="wrapper">

                    <div class="row">
                        <div class="col-lg-12">
                            <h1 style="margin-top: 0;">{{ ucwords($product->name) }}</h1>
                            <div class="vendor-last-login">
                                Category : {{ ucwords($product->category->name) }}
                            </div>
                            <div class="vendor-last-login">
                                Brand : {{ ucwords($product->brand->name) }}
                            </div>
                            <div class="vendor-last-login">
                                Published : {{ ($product->published == 'Y' ? 'Yes' : 'No') }}
                            </div>
                            <div class="vendor-feedback">
                                Unit Price : LKR {{ $product->unit_price }}
                            </div>
                            <div class="vendor-feedback">
                                UOM :{{ ($product->uom == '1' ? 'Square feet' : 'Linear Length') }}
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>Description</h4>
                            <div class="product-descriptions">
                                <p style="display: inline-block;">
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <br/>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <a  class="link" href='{{  url("/activities/$product->id/Product") }}' class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Track Product</a>
                                <a href='{{ url("/products/{$product->id}/edit") }}' class="btn btn-danger pull-right" value=""><span class="glyphicon glyphicon-edit"></span> Edit Product</a>
                            </div>
                        </div>
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