@extends('layouts.app')

@section('content')
    @include ("header.content-header")
    @include ("inquiries.reschedule")
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Inquiries</li>
            <li class="active">Manage Inquiries</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                    <div class="col-lg-3">
                        Manage Inquiries
                    </div>
                    <div class="col-lg-9">

                        <form role="form" action="{{ url('/search/Inquiry') }}" method="GET">
                            <div class="input-group">
                                {{--<div class="input-group-btn search-panel">--}}

                                {{--</div>--}}
                                <div class="col-xs-2">
                                    <select style="margin-top: 5px;" id="agent" name="agent" class="form-control">
                                        <option value=''>Agent</option>
                                        @foreach($agents as $agent)
                                            <option value='{{ $agent->id }}'  @if(isset($searchArray['agent']) && $searchArray['agent'] == $agent->id ) selected @endif>{{ $agent->name.'-'.$agent->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <select  style="margin-top: 5px;" id="status" name="status" class="form-control">
                                        <option value=''>Status</option>
                                        <option value='1'  @if(isset($searchArray['status']) && $searchArray['status']=='1' ) selected @endif>Assigned</option>
                                        <option value='2'  @if(isset($searchArray['status']) && $searchArray['status']=='2' ) selected @endif>Visited</option>
                                        <option value='3'  @if(isset($searchArray['status']) && $searchArray['status']=='3' ) selected @endif>Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <select  style="margin-top: 5px;" id="inquiry_source" name="inquiry_source" class="form-control">
                                        <option value=''>Source</option>
                                        <option value='1'  @if(isset($searchArray['inquiry_source']) && $searchArray['inquiry_source']=='1' ) selected @endif>Internal</option>
                                        <option value='2'  @if(isset($searchArray['inquiry_source']) && $searchArray['inquiry_source']=='2' ) selected @endif>External</option>
                                    </select>
                                </div>
                                <div class="col-xs-3">
                                    <input style="margin-top: 5px;" type="text" class="form-control" id="customer" name="customer" placeholder="Cust Name,Phone,Email" value="{{ $searchArray['customer'] or '' }}" >
                                </div>
                                <div class="col-xs-3">
                                    <input style="margin-top: 5px;" type="text" class="form-control" id="keyword" name="keyword" placeholder="Inq No" value="{{ $searchArray['keyword'] or '' }}" >
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

                    {{--<form role="form" action="{{ url('/search/Saleslead') }}" method="GET">--}}
                    {{--<div class="form-group">--}}
                    {{--<label for="inputEmail3" class="col-sm-2 control-label">Keyword</label>--}}
                    {{--<div class="col-sm-4">--}}
                    {{--<input type="text" class="form-control" id="search" name="search" placeholder="Search By Customer Name" value="{{ $search or '' }}" >--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="form-group">--}}

                    {{--<button type="submit" class="btn btn-primary" name="search_submit" id="search_submit">--}}
                    {{--Search--}}
                    {{--</button>--}}

                    {{--</div>--}}

                    {{--</form>--}}

                    @if($inquiries->count() > 0)

                        {{--<div style="padding-left:30%;">--}}
                        {{--<button id="trash" class="btn btn-default btn-sm" style="display:none;width:10%;height:15%;z-index:1;position: absolute;" onclick="deleteProducts()" title="delete">--}}
                        {{--<svg class="glyph stroked trash"><use xlink:href="#stroked-trash"/></svg>--}}
                        {{--</button>--}}
                        {{--</div>--}}

                        {{--<br>--}}
                        {{--<br>--}}
                        {{--<br>--}}
                        <div style="overflow-x:auto;">
                            <div style="float:right"><h1>Total:{{ $inquiries->total() }}</h1></div>
                            <table data-toggle="table" id="example2" data-row-style="rowStyle">
                                <thead>

                                <tr>
                                    {{--<th>Select <input type="checkbox" id="selectAll" value="{{ $collectionId->toJson() }}"></th>--}}
                                    {{--<th>Id</th>--}}
                                    <th>Inquiry Id</th>
                                    <th>Customer Name</th>
                                    <th>Customer Phone</th>
                                    <th>Customer Email</th>
                                    {{--<th>Customer Address</th>--}}
                                    <th>Agent</th>

                                    {{--<th>Planned Visit Date Time</th>--}}
                                    {{--<th>Inq Source</th>--}}
                                    {{--<th>Max Discount</th>--}}
                                    {{--<th>Actual Visit Date Time</th>--}}
                                    {{--<th>Cancel Reason</th>--}}
                                    <th>Source</th>
                                    <th>Status</th>
                                    <th>Re-Schedule</th>
                                    <th>View</th>
                                    {{--@if(Auth::User()->can('CanEditRoles'))--}}
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

                                @foreach ($inquiries as $inquiry)
                                    <tr>
                                        {{--<td><input type="checkbox" class="checkbox1" value="{{ $product->id }}"></td>--}}
                                        {{--<td>{{ (($inquiries->currentPage()-1)*$inquiries->perPage())+$id }}</td>--}}
                                        <td>{{ 'inq_'.sprintf('%08d', $inquiry->id) }}</td>
                                        <td>{{ $inquiry->saleslead->customer->name }}</td>
                                        <td>{{ $inquiry->saleslead->customer->mobile }}</td>
                                        <td>{{ $inquiry->saleslead->customer->email }}</td>
                                        {{--<td>{{ $inquiry->saleslead->customer->address }}</td>--}}
                                        <td>{{ $inquiry->agent->name }}</td>
                                        {{--<td>{{ $inquiry->planned_visit_date_time}}</td>--}}
                                        {{--<td>{{ $inquiry->inquiry_source }}</td>--}}
                                        {{--<td>{{ $inquiry->maximum_discount }}</td>--}}
                                        {{--<td>{{ $inquiry->actual_visit_date_time }}</td>--}}
                                        {{--<td>{{ $inquiry->cancel_reason }}</td>--}}
                                        {{--<td>{{ $inquiry->status }}</td>--}}
                                        <td>@if($inquiry->inquiry_source == '1')<span class='label label-success'>Internal</span>@else<span class='label label-warning'>External</span>@endif</td>
                                        <td>@if($inquiry->status == '1')<span class='label label-info'>Assigned</span>@elseif($inquiry->status == '2')<span class='label label-warning'>Visited</span>@else<span class='label label-success'>Cancelled</span>@endif</td>
                                        <td><a class="link1" href='{{  url("/inquiries/$inquiry->id/reschedule") }}'><i class="fa fa-bars"></i></a></td>
                                        {{--@if(Auth::User()->can('CanTrackRoles'))--}}
                                        <td><a  href='{{  url("/inquiries/$inquiry->id/view") }}'><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                                        <td><a class="link" href='{{  url("/activities/$inquiry->id/Inquiry") }}'><i class="fa fa-road"></i></a></td>
                                        {{--@endif--}}
                                        @php $id++; @endphp
                                    </tr>
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

                        {{ $inquiries->links() }}

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

        var rescheduleUrl;

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
            var url = $(this).attr('href');
            rescheduleUrl = url.substr(0,url.indexOf('reschedule')-1);
            //alert(rescheduleUrl);
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function (result){

                    //console.log(result);
                    if(result.status == 400){

                        $('.list-group').html(result.message);
                        $("#canNotRescheduleModal").modal('show');
                        return;

                    }

//                    $('.list-group').html(result);
                      $("#agent").val(result.data.agent_name);
                      $("#planned_visit_date_time").val(result.data.planned_visit_date_time);
                      $("#actual_visit_date_time").val(result.data.actual_visit_date_time);
                      $("#canRescheduleModal").modal('show');


                },
                error:function(){
                    alert("error!!!!");
                }
            });


        });



        $("#success").fadeOut(5000);
        $("#error").fadeOut(5000);



    </script>

@endsection