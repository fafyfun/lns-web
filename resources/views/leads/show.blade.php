@extends('layouts.app')

@section('content')
    @include ("header.content-header")
    @include ("inquiries.convert")
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Sales Leads</li>
            <li class="active">Manage Leads</li>
        </ol>
    </div>



    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-3">
                            Manage Sales Leads
                        </div>
                        <div class="col-lg-9">

                            <form role="form" action="{{ url('/search/Saleslead') }}" method="GET">
                                <div class="input-group">
                                    {{--<div class="input-group-btn search-panel">--}}

                                    {{--</div>--}}
                                    <div class="col-xs-4">
                                        <select style="margin-top: 5px;" id="source" name="source" class="form-control">
                                            <option value=''>Source</option>
                                            <option value='1'  @if(isset($searchArray['source']) && $searchArray['source']=='1' ) selected @endif>Internal</option>
                                            <option value='2'  @if(isset($searchArray['source']) && $searchArray['source']=='2' ) selected @endif>External</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <select  style="margin-top: 5px;" id="status" name="status" class="form-control">
                                            <option value=''>Status</option>
                                            <option value='1'  @if(isset($searchArray['status']) && $searchArray['status']=='1' ) selected @endif>Open</option>
                                            <option value='2'  @if(isset($searchArray['status']) && $searchArray['status']=='2' ) selected @endif>Contacted</option>
                                            </select>
                                    </div>
                                                <div class="col-xs-4">
                                                    <input style="margin-top: 5px;" type="text" class="form-control" id="keyword" name="keyword" placeholder="Name,Phone,Email" value="{{ $searchArray['keyword'] or '' }}" >
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
                                {{--<input type="text" class="form-control" id="search" name="search" placeholder="Search By Customer Name,Phone or Email" value="{{ $search or '' }}" >--}}
                            {{--</div>--}}
                            {{--<label for="inputEmail3" class="col-sm-2 control-label">Source</label>--}}
                            {{--<div class="col-sm-4">--}}
                                {{--<select id="source" name="source" class="form-control select2">--}}
                                    {{--<option value=''>--Select--</option>--}}
                                    {{--<option value='1'  @if(isset($searchArray['source']) && $searchArray['source']=='1' ) selected @endif>Internal</option>--}}
                                    {{--<option value='2'  @if(isset($searchArray['source']) && $searchArray['source']=='2' ) selected @endif>External</option>--}}
                                {{--</select>--}}
                            {{--</div>--}}

                        {{--</div>--}}


                        {{--<div class="form-group">--}}

                            {{--<label for="inputEmail3" class="col-sm-2 control-label">Status</label>--}}
                            {{--<div class="col-sm-4">--}}
                                {{--<select id="status" name="status" class="form-control select2">--}}
                                    {{--<option value=''>--Select--</option>--}}
                                    {{--<option value='1'  @if(isset($searchArray['status']) && $searchArray['status']=='1' ) selected @endif>Open</option>--}}
                                    {{--<option value='2'  @if(isset($searchArray['status']) && $searchArray['status']=='2' ) selected @endif>Contacted</option>--}}
                                {{--</select>--}}
                            {{--</div>--}}

                        {{--</div>--}}

                        {{--<br>--}}
                        {{--<br>--}}
                        {{--<br>--}}
                        {{--<br>--}}

                        {{--<div class="btn-group" style="padding-left:18%;">--}}
                            {{--<button type="submit" class="btn btn-primary" name="search_submit" id="search_submit">--}}
                                {{--Search--}}
                            {{--</button>--}}
                        {{--</div>--}}


                    {{--</form>--}}

                    @if($leads->count() > 0)

                        {{--<div style="padding-left:30%;">--}}
                            {{--<button id="trash" class="btn btn-default btn-sm" style="display:none;width:10%;height:15%;z-index:1;position: absolute;" onclick="deleteProducts()" title="delete">--}}
                                {{--<svg class="glyph stroked trash"><use xlink:href="#stroked-trash"/></svg>--}}
                            {{--</button>--}}
                        {{--</div>--}}

                        {{--<br>--}}
                        {{--<br>--}}
                        {{--<br>--}}
                        <div style="overflow-x:auto;">
                            <div style="float:right"><h1>Total:{{ $leads->total() }}</h1></div>
                            <table data-toggle="table" id="example2" data-row-style="rowStyle">
                                <thead>

                                <tr>
                                    {{--<th>Select <input type="checkbox" id="selectAll" value="{{ $collectionId->toJson() }}"></th>--}}
                                    <th>Id</th>
                                    <th>Customer Name</th>
                                    <th>Customer Phone</th>
                                    <th>Customer Email</th>
                                    <th>Source</th>
                                    <th>Status</th>
                                    {{--@if(Auth::User()->can('CanEditRoles'))--}}
                                    <th>Action</th>
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

                                @foreach ($leads as $lead)
                                    <tr>
                                        {{--<td><input type="checkbox" class="checkbox1" value="{{ $product->id }}"></td>--}}
                                        <td>{{ (($leads->currentPage()-1)*$leads->perPage())+$id }}</td>
                                        <td>{{ $lead->customer->name }}</td>
                                        <td>{{ $lead->customer->mobile }}</td>
                                        <td>{{ $lead->customer->email }}</td>
                                        <td>@if($lead->lead_source == '1')<span class='label label-success'>Internal</span>@else<span class='label label-warning'>External</span>@endif</td>
                                        <td>@if($lead->status == '1')<span class='label label-default'>Open</span>@else<span class='label label-info'>Contacted</span>@endif</td>
                                        <td>
                                            @if($lead->status == '1')
                                                <a class="link1 btn btn-primary btn-xs" href='{{  url("/converttoinquiry/$lead->id") }}'>Convert To Inquiry</a>
                                            @endif
                                        </td>
                                        {{--@if(Auth::User()->can('CanTrackRoles'))--}}
                                        <td><a class="link" href='{{  url("/activities/$lead->id/Saleslead") }}'><i class="fa fa-road"></i></a></td>
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

                        {{ $leads->links() }}

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

        var convertInquiryUrl;

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
            convertInquiryUrl = e.target.href;
            $("#convert_to_inquiry").modal('show');
            $('#convert')[0].reset();

        });

//        function showConvertForm(e){
//
//            e.preventDefault();
//            convertInquiryUrl = e.target.href;
//            $("#convert_to_inquiry").modal('show');
//            $('#convert')[0].reset();
//
//        }


        $("#success").fadeOut(5000);
        $("#error").fadeOut(5000);



    </script>

@endsection