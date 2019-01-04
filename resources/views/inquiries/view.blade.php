@extends('layouts.app')


@section('content')
    @include ("header.content-header")

    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Inquiries</li>
            <li class="active">Inquiry Details</li>
        </ol>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="page-header">Inquiry Details</h1>
                </div>
                <div class="col-lg-6">
                    <a href="javascript:history.back()" class="btn btn-primary pull-right">Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">

            <div class="row">
                <div class="col-lg-6">
                    <div class="wrapper">
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 style="margin-top: 0;">Customer Informations</h1>
                                <div class="vendor-last-login" style="padding-bottom: 10px;">
                                    Name : {{ ucwords($inquiry->saleslead->customer->name) }}
                                </div>
                                <div class="vendor-last-login" style="padding-bottom: 10px;">
                                    Address : {{ ucwords($inquiry->saleslead->customer->address) }}
                                </div>
                                <div class="vendor-last-login" style="padding-bottom: 10px;">
                                    Mobile : {{ $inquiry->saleslead->customer->mobile }}
                                </div>
                                @if($inquiry->saleslead->customer->telephone !='')
                                    <div class="vendor-feedback" style="padding-bottom: 10px;">
                                        Telephone :  {{ $inquiry->saleslead->customer->telephone }}
                                    </div>
                                @endif
                                <div class="vendor-feedback" style="padding-bottom: 10px;">
                                    Email :{{ $inquiry->saleslead->customer->email }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="wrapper">
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 style="margin-top: 0;">Inquiry Informations</h1>
                                <div class="vendor-last-login" style="padding-bottom: 10px;">
                                    Agent : {{ ucwords($inquiry->agent->name) }}
                                </div>
                                <div class="vendor-last-login" style="padding-bottom: 10px;">
                                    Planned Visit Date : {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $inquiry->planned_visit_date_time )->toDateString() }}
                                </div>
                                <div class="vendor-last-login" style="padding-bottom: 10px;">
                                    Planned Visit Time : {{ Carbon\Carbon::parse($inquiry->planned_visit_date_time )->format('g:i A') }}
                                </div>
                                <div class="vendor-feedback" style="padding-bottom: 10px;">
                                    Inquiry Source : {{ ($inquiry->inquiry_source == '1' ? 'Internal' : 'External') }}
                                </div>
                                <div class="vendor-feedback" style="padding-bottom: 10px;">
                                    Maximum Discount : {{ $inquiry->maximum_discount }}%
                                </div>
                                <div class="vendor-last-login" style="padding-bottom: 10px;">
                                    Actual Visit Date : {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $inquiry->actual_visit_date_time )->toDateString() }}
                                </div>
                                <div class="vendor-last-login" style="padding-bottom: 10px;">
                                    Actual Visit Time : {{ Carbon\Carbon::parse($inquiry->actual_visit_date_time)->format('g:i A') }}
                                </div>
                                @if($inquiry->cancel_reason != '')
                                    <div class="vendor-last-login" style="padding-bottom: 10px;">
                                        Cancel Reason : {{ $inquiry->cancel_reason }}
                                    </div>
                                @endif
                                <div class="vendor-last-login" style="padding-bottom: 10px;">
                                    Status : @if($inquiry->status == '1')<span class='label label-info'>Assigned</span>@elseif($inquiry->status == '2')<span class='label label-warning'>Visited</span>@else<span class='label label-success'>Cancelled</span>@endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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