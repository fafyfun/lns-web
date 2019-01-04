@extends('layouts.app')

@section('content')
    @include ("header.content-header")
    @include ("quotations.approve")
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Quotations</li>
            <li class="active">Manage Quotations</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-3">
                            Manage Quotations
                        </div>
                        <div class="col-lg-9">

                            <form role="form" action="{{ url('/search/Quotation') }}" method="GET">
                                <div class="input-group">
                                    <div class="col-xs-3">
                                        <select style="margin-top: 5px;" id="agent" name="agent" class="form-control">
                                            <option value=''>Agent</option>
                                            @foreach($agents as $agent)
                                                <option value='{{ $agent->id }}'  @if(isset($searchArray['agent']) && $searchArray['agent'] == $agent->id ) selected @endif>{{ $agent->name.'-'.$agent->email }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xs-3">
                                        <select  style="margin-top: 5px;" id="status" name="status" class="form-control">
                                            <option value=''>Status</option>
                                            <option value='1'  @if(isset($searchArray['status']) && $searchArray['status']=='1' ) selected @endif>Confirmed</option>
                                            <option value='2'  @if(isset($searchArray['status']) && $searchArray['status']=='2' ) selected @endif>Approved</option>
                                            <option value='3'  @if(isset($searchArray['status']) && $searchArray['status']=='3' ) selected @endif>Cancelled</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-3">
                                    <input style="margin-top: 5px;" type="text" class="form-control" id="quotation" name="quotation" placeholder="Quotation ID" value="{{ $searchArray['quotation'] or '' }}" >
                                    </div>
                                    <div class="col-xs-3">
                                        <input style="margin-top: 5px;" type="text" class="form-control" id="inquiry" name="inquiry" placeholder="Inquiry ID" value="{{ $searchArray['inquiry'] or '' }}" >
                                    </div>
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

                    @if($quotations->count() > 0)

                        <div style="padding-left:30%;">
                            <button id="trash" class="btn btn-default btn-sm" style="display:none;width:10%;height:15%;z-index:1;position: absolute;" onclick="deleteQuotations()" title="delete">
                                <svg class="glyph stroked trash"><use xlink:href="#stroked-trash"/></svg>
                            </button>
                        </div>

                        <div style="overflow-x:auto;">
                            <div style="float:right"><h1>Total:{{ $quotations->total() }}</h1></div>
                            <table data-toggle="table" id="example2" data-row-style="rowStyle">
                                <thead>

                                <tr>
                                    {{--<th>Select <input type="checkbox" id="selectAll" value="{{ $collectionId->toJson() }}"></th>--}}
                                    <th>Id</th>
                                    <th>Quote ID</th>
                                    <th>Inquiry ID</th>
                                    <th>Agent</th>
                                    <th>Revision No</th>
                                    <th>Status</th>
                                    <th>View</th>
                                    {{--@if(Auth::User()->can('CanEditRoles'))--}}
                                    {{--<th>Action</th>--}}
                                    {{--@endif--}}
                                    {{--@if(Auth::User()->can('CanTrackRoles'))--}}
                                    <th>Track</th>
                                    {{--@endif--}}
                                </tr>
                                </thead>

                                <tbody>

                                @php
                                    $id=1;
                                @endphp

                                @foreach ($quotations->groupBy('inquiry_id') as $quotationsByInquiry)

                                    @foreach($quotationsByInquiry as $quotation)

                                    <tr>
                                        {{--<td><input type="checkbox" class="checkbox1" value="{{ $quotation->id }}"></td>--}}
                                        <td>{{ (($quotations->currentPage()-1)*$quotations->perPage())+$id }}</td>
                                        <td>{{ 'quote_'.sprintf('%08d', $quotation->id) }}</td>
                                        <td>{{ 'inq_'.sprintf('%08d', $quotation->inquiry->id)  }}</td>
                                        <td>{{ $quotation->inquiry->agent->name }}</td>
                                        <td>
                                            {{ $quotation->revision_no }}
                                            @if($quotation->status == '1' && !$quotationsByInquiry->pluck('status')->contains('2'))
                                                <a class="link1 btn btn-primary btn-xs" href='{{  url("/quotations/$quotation->id/approve") }}'>Approve</a>
                                                @endif
                                        </td>
                                        <td>
                                            @if($quotation->status == '1')
                                                {{--<a class="link1 btn btn-primary btn-xs" href='#'>Confirmed</a>--}}
                                                <span class='label label-info'>Confirmed</span>
                                            @elseif($quotation->status == '2')
                                                <span class='label label-warning'>Approved</span>
                                            @else
                                                <span class='label label-success'>Cancelled</span>
                                            @endif
                                                @if($quotation->latest == '1')
                                                    <span class='label label-info'>Latest</span>
                                                @endif
                                        </td>
                                        <td><a href='{{ url("/quotations/$quotation->id/detail") }}' class=""><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                                        {{--@if(Auth::User()->can('CanEditRoles'))--}}
                                        {{--<td><a href='{{ url("/quotations/$quotation->id/edit") }}'><i class="fa fa-edit"></i></a></td>--}}
                                        {{--@endif--}}
                                        {{--@if(Auth::User()->can('CanTrackRoles'))--}}
                                        <td><a class="link" href='{{  url("/activities/$quotation->id/Quotation") }}'><i class="fa fa-road"></i></a></td>
                                        {{--@endif--}}
                                        @php $id++; @endphp
                                    </tr>
                                        @endforeach
                                @endforeach
                                </tbody>
                            </table>
                            @else
                                <table data-toggle="table" id="example3" data-row-style="rowStyle">
                                    <tr>
                                        <td>No Result Found</td>
                                    </tr>
                                </table>
                            @endif
                        </div>

                        {{ $quotations->links() }}

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

        var approveUrl;

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

        $(document).on("click", ".link1", function(e){

            e.preventDefault();
            approveUrl = $(this).attr('href');
            $("#approveModal").modal('show');
            //alert(approveUrl);



        });


        $("#success").fadeOut(5000);
        $("#error").fadeOut(5000);

        var count=0;
        var deleteBrandArray=[];



        $(document).on("change", ".checkbox1", function () {

            if(this.checked) {

                count=count+1;
                $("#trash").css("display", "block");
                //alert(this.value);
                deleteBrandArray.push(JSON.parse(this.value));
                //
                console.log(deleteBrandArray);
                //alert(count);
            }
            if(!this.checked){
                count=count-1;
                $("#selectAll").prop('checked',false);
                if(count==0){
                    $("#trash").css("display", "none");
                }
                var index=deleteBrandArray.indexOf(this.value);
                deleteBrandArray.splice(index, 1);
                console.log(deleteBrandArray);
                //alert(count);

            }
        });



        $(document).on("change", "#selectAll", function () {
            if(this.checked) {
                deleteBrandArray=[];
                $.each(JSON.parse(this.value), function(ky, loc) {
                    deleteBrandArray.push(loc);
                });

                //allID.push(this.value);
                //console.log(allID);
                $(".checkbox1").prop('checked',true);
                count=$("[type='checkbox']:checked").length-1;
                $("#trash").css("display", "block");
                //alert(count);
                console.log(deleteBrandArray);
            }
            if(!this.checked){
                deleteBrandArray=[];
                if(count==0){
                    $("#trash").css("display", "none");
                }
                $(".checkbox1").prop('checked',false);
                count=count-($("[type='checkbox']:not(:checked)").length-1);
                $("#trash").css("display", "none");
                //alert(count);
                console.log(deleteBrandArray);
            }


        });



        function deleteBrands(){
            $.ajax({
                url:"@php echo url('/deletebrands') @endphp",
                type: "DELETE",
                data:{deleteBrand:deleteBrandArray},
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