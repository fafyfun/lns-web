@extends('layouts.app')


@section('content')
    @include ("header.content-header")

    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Inquiries</li>
            <li class="active">Installation Details</li>
        </ol>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-6">
                    Installation Details
                </div>
                <div class="col-lg-6">
                    <a href="javascript:history.back()" class="btn btn-primary pull-right">Back</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive" src="{{ url('/images/lns-logo.png') }}" style="width:200px;height:100px;margin-left: auto;margin-right: auto;margin-top: 1%">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 ">
                    <div style="text-align: center;">
                        <h3>INSTALLATION JOB CARD</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div>
                        Planned Deleivery Date : {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $installation->planned_delivery_date_time )->toDateString() }}
                    </div>
                    <div>
                        Planned Deleivery Time : {{ Carbon\Carbon::parse($installation->planned_delivery_date_time )->format('g:i A') }}
                    </div>
                    <div>
                        Actual Deleivery Date : @if(isset($installation->actual_delivery_date_time)){{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $installation->actual_delivery_date_time )->toDateString() }} @endif
                    </div>
                    <div>
                        Actual Deleivery Time : @if(isset($installation->actual_delivery_date_time)){{ Carbon\Carbon::parse($installation->actual_delivery_date_time )->format('g:i A') }} @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        Installation ID : INST-{{ sprintf('%08d', $installation->id) }}
                    </div>
                    <div>
                        Installation Agent : {{ $installation->insatllaionlead->name }}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        Customer Name : {{ $installation->job->quotation->inquiry->saleslead->customer->name }}
                    </div>
                    <div>
                        Customer Email : {{ $installation->job->quotation->inquiry->saleslead->customer->email }}
                    </div>
                    <div>
                        Customer Phone : {{ $installation->job->quotation->inquiry->saleslead->customer->mobile }}
                    </div>
                    <div class="row">
                        <div class="col-xs-4">CustomerAddress:</div>
                        <div class="col-xs-4">{{ $installation->job->quotation->inquiry->saleslead->customer->address }}</div>
                    </div>
                </div>
            </div>
            <br>
            <div>
                <a href='{{ url("/inquiries/{$installation->job->quotation->inquiry_id}/view") }}'><span class='label label-info'>View Inquiry</span></a>
                <a href='{{ url("/quotations/{$installation->job->quotation_id}/detail") }}'><span class='label label-info'>View Quoatation</span></a>
            </div>
            <br>
            @foreach($installation->job->quotation->rooms as $room)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        {{ $room->name }}
                                    </div>
                                    <div class="panel-body">
                                        @foreach($room->walls as $wall)
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div>
                                                                {{ $wall->name }}
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <img class="img-responsive" src='{{ url("/images/products/{$wall->product->image}") }}' style="width:200px;height:100px;">
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div>
                                                                        prod-{{ sprintf('%08d', $wall->product->id) }}
                                                                    </div>
                                                                    <div>
                                                                        <b>{{ $wall->product->name }}</b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div>

                                                            </div>
                                                            <br>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <div>
                                                                        Width : 50ft
                                                                    </div>
                                                                    <div>
                                                                        Height : 50ft
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div>
                                                                        Width : 50ft
                                                                    </div>
                                                                    <div>
                                                                        Height : 50ft
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>




    {{--<div class="row">--}}
    {{--<div class="wrapper">--}}
    {{--<div class="row">--}}
    {{--<a  class="link" href='{{  url("/activities/$inquiry->id/Product") }}' class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Track Product</a>--}}
    {{--<a href='{{ url("/products/{$inquiry->id}/edit") }}' class="btn btn-danger pull-right" value=""><span class="glyphicon glyphicon-edit"></span> Edit Product</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}



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