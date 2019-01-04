@extends('layouts.app')

@section('content')
    @include ("header.content-header")

    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Quotations</li>
            <li class="active">Quotation Details</li>
        </ol>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-6">
                    Quotation Details
                </div>
                <div class="col-lg-6">
                    <br/>
                    <a href="javascript:history.back()" class="btn btn-primary pull-right">Back</a>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="product-detail-2">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="wrapper">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h1 style="margin-top: 0;">Inquiry Info</h1>
                                    <div class="vendor-last-login">
                                        <a  href='{{  url("/inquiries/{$quotation->inquiry_id}/view") }}'>View Inquiry</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="wrapper">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h1 style="margin-top: 0;">Quotation Info</h1>
                                    <div class="vendor-last-login">
                                        Installation Fee : Rs.{{ $quotation->installation_fee }}
                                    </div>
                                    <div class="vendor-last-login">
                                        Transport Fee : Rs.{{ $quotation->transport_fee }}
                                    </div>
                                    <div class="vendor-last-login">
                                        Removable Fee : Rs.{{ $quotation->removable_fee }}
                                    </div>
                                    <div class="vendor-last-login">
                                        Cleaning Fee : Rs.{{ $quotation->cleaning_fee }}
                                    </div>
                                    <div class="vendor-last-login">
                                        Other Fee : Rs.{{ $quotation->other_fee }}
                                    </div>
                                    <div class="vendor-last-login">
                                        Discount : {{ $quotation->discount }}%
                                    </div>
                                    <div class="vendor-last-login">
                                        Total Cost : Rs.{{ $quotation->total_cost }}
                                    </div>
                                    <div class="vendor-last-login">
                                        Total Cost Country: Rs.{{ $quotation->total_cost_country }}
                                    </div>
                                    <div class="vendor-last-login">
                                        Status : @if($quotation->status == '1')
                                            <span class='label label-info'>Confirmed</span>
                                        @elseif($quotation->status == '2')
                                            <span class='label label-warning'>Approved</span>
                                        @else
                                            <span class='label label-success'>Cancelled</span>
                                        @endif
                                        @if($quotation->latest == '1')
                                            <span class='label label-info'>Latest</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <hr>


    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-12">
                    Rooms Info
                </div>
            </div>
        </div>
        <div class="panel-body">

            @foreach($quotation->rooms as $qr)
                <b>{{  $qr->name }} Info</b>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="wrapper">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="vendor-last-login">
                                        Name : {{ $qr->name }}
                                    </div>
                                    <div class="vendor-last-login">
                                        Description : {{ $qr->description }}
                                    </div>
                                    <div class="vendor-last-login">
                                        Total Price : Rs.{{ $qr->total_price }}
                                    </div>
                                    <div class="vendor-last-login">
                                        Total Price Country : {{ $qr->total_price_country }}
                                    </div>
                                </div>
                            </div>
                            <br>
                            <h3 style="margin-top: 0;">Walls Info</h3>
                            <div class="row">
                                @foreach($qr->walls as $wall)

                                    <div class="col-lg-6">
                                        <b>{{  $wall->name }} Info</b>
                                        <div class="vendor-last-login">
                                            Name : {{ $wall->name }}
                                        </div>
                                        {{--<div class="vendor-last-login">--}}
                                        {{--Description : {{ $wall->wall_area }}--}}
                                        {{--</div>--}}
                                        <div class="vendor-last-login">
                                            Total Price : Rs.{{ $wall->wall_area_unit }}
                                        </div>
                                        <div class="vendor-last-login">
                                            Total Price Country : {{ $wall->wall_cost }}
                                        </div>
                                        <div class="vendor-last-login">
                                            Total Price Country : {{ $wall->wall_cost_country }}
                                        </div>
                                        <b>Product</b>
                                        <div class="vendor-last-login">
                                            <img src='{{ url("/images/products/{$wall->product->image}") }}' alt="First slide" style="width: 500px;min-height: 100px;">
                                        </div>
                                        @if(($wall->wallimages)->isNotEmpty())
                                            <b>Wall Images</b>
                                            <div class="vendor-last-login">
                                                @foreach($wall->wallimages as $wi)
                                                    <img src='{{ url("/images/walls/{$wi->image}") }}' alt="First slide" style="width: 200px;min-height: 100px;">
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
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