@extends('layouts.app')

@section('content')
    @include ("header.content-header")
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Sales Targets</li>
            <li class="active">Manage SalesTargets</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-3">
                            Manage Targets
                        </div>
                        <div class="col-lg-9">

                            <form role="form" action="{{ url('/search/Salestarget') }}" method="GET">
                                <div class="input-group pull-right">
                                    <div class="input-group">
                                        {{--<div class="input-group-btn search-panel">--}}

                                        {{--</div>--}}
                                        <div class="col-xs-6">
                                            <select style="margin-top: 5px;" id="agent" name="agent" class="form-control">
                                                <option value=''>Agent</option>
                                                @foreach($agents as $agent)
                                                    <option value='{{ $agent->id }}'  @if(isset($searchArray['agent']) && $searchArray['agent'] == $agent->id ) selected @endif>{{ $agent->name.'-'.$agent->email }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xs-6">
                                            <input style="margin-top: 5px;" type="text" class="form-control" id="keyword" name="keyword" placeholder="Year" value="{{ $searchArray['keyword'] or '' }}" >
                                        </div>


                                        <span class="input-group-btn ">
                                                                <button class="btn btn-default" type="submit">
                                                                    <span class="glyphicon glyphicon-search"></span>
                                                                </button>
                                                            </span>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="panel-body">

                    @if($salestargets->count() > 0)

                        <div style="padding-left:30%;">
                            <button id="trash" class="btn btn-default btn-sm" style="display:none;width:10%;height:15%;z-index:1;position: absolute;" onclick="deleteSalesTargets()" title="delete">
                                <svg class="glyph stroked trash"><use xlink:href="#stroked-trash"/></svg>
                            </button>
                        </div>

                        <div style="overflow-x:auto;">
                            {{--<div style="float:right"><h1>Total:{{ $salestargets->total() }}</h1></div>--}}
                            <table data-toggle="table" id="example2" data-row-style="rowStyle">
                                <thead>

                                <tr>
                                    {{--<th>Select <input type="checkbox" id="selectAll" value="{{ $collectionId->toJson() }}"></th>--}}
                                    {{--<th>Id</th>--}}
                                    <th>Agent Name</th>
                                    <th>Year</th>
                                    <th>APR</th>
                                    <th>MAY</th>
                                    <th>JUN</th>
                                    <th>JUL</th>
                                    <th>AUG</th>
                                    <th>SEP</th>
                                    <th>OCT</th>
                                    <th>NOV</th>
                                    <th>DEC</th>
                                    <th>JAN</th>
                                    <th>FEB</th>
                                    <th>MAR</th>
                                    {{--@if(Auth::User()->can('CanEditRoles'))--}}
                                    <th>Action</th>
                                    {{--@endif--}}
                                    {{--@if(Auth::User()->can('CanTrackRoles'))--}}
                                    {{--<th>Track</th>--}}
                                    {{--@endif--}}
                                </tr>
                                </thead>

                                <tbody>

                                @php
                                    $id=1;
                                @endphp

                                @foreach ($salestargets->groupBy('agent_id') as $key1 => $agentGroup )

                                        {{--<td>{{ $agentGroup[0]->agent->name }}</td>--}}
                                        {{--<td><input type="checkbox" class="checkbox1" value="{{ $salestarget->id }}"></td>--}}
                                        {{--<td>{{ (($salestargets->currentPage()-1)*$salestargets->perPage())+$id }}</td>--}}
                                        @foreach ($agentGroup->groupBy('year') as $key2 => $val)
                                            <tr>
                                            <td>{{ $agentGroup[0]->agent->name }}</td>
                                            <td>{{ $key2 }}</td>
                                            @foreach ($val as $v)

                                                <td>{{ $v->target }}</td>

                                            @endforeach
                                                <td><a href='{{ url("/salestarget/{$agentGroup[0]->agent->id}/$key2/edit") }}'><i class="fa fa-edit"></i></a></td>
                                            </tr>



                                        @endforeach
                                        {{--@if(Auth::User()->can('CanEditRoles'))--}}
                                        {{--<td><a href='{{ url("/salestarget/$salestarget->id/edit") }}'><i class="fa fa-edit"></i></a></td>--}}
                                        {{--@endif--}}
                                        {{--@if(Auth::User()->can('CanTrackRoles'))--}}
                                        {{--<td><a class="link" href='{{  url("/activities/$salestarget->id/Salestarget") }}'><i class="fa fa-road"></i></a></td>--}}
                                        {{--@endif--}}
                                        {{--@php $id++; @endphp--}}
                                    {{--</tr>--}}
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

                        {{ $salestargets->links() }}

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



        function deleteSalesTargets(){
            $.ajax({
                url:"@php echo url('/deletesalestargets') @endphp",
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