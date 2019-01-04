@extends('layouts.app')

@section('content')
    @include ("header.content-header")
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Permissions</li>
            <li class="active">Manage Permission</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-3">
                            Manage Permissions
                        </div>
                        <div class="col-lg-6">

                            <form role="form" action="{{ url('/search/Permission') }}" method="GET">
                                <div class="input-group">
                                    {{--<div class="input-group-btn search-panel">--}}

                                    {{--</div>--}}
                                    <input style="margin-top: 5px;" type="text" class="form-control" id="search" name="search" placeholder="Search By Name or Short Name" value="{{ $search or '' }}" >
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

                    @if($permissions->count() > 0)

                        <div style="padding-left:30%;">
                            <button id="trash" class="btn btn-default btn-sm" style="display:none;width:10%;height:15%;z-index:1;position: absolute;" onclick="deletePermissions()" title="delete">
                                <svg class="glyph stroked trash"><use xlink:href="#stroked-trash"/></svg>
                            </button>
                        </div>
                        <div style="overflow-x:auto;">
                            <div style="float:right"><h1>Total:{{ $permissions->total() }}</h1></div>
                            <table data-toggle="table" id="example2" data-row-style="rowStyle">
                                <thead>

                                <tr>
                                    <th>Select <input type="checkbox" id="selectAll" value="{{ $collectionId->toJson() }}"></th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Short Name</th>
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

                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td><input type="checkbox" class="checkbox1" value="{{ $permission->id }}"></td>
                                        <td>{{ (($permissions->currentPage()-1)*$permissions->perPage())+$id }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->shortname }}</td>
                                        {{--@if(Auth::User()->can('CanEditRoles'))--}}
                                        <td><a href='{{ url("/permissions/$permission->id/edit") }}'><i class="fa fa-edit"></i></a></td>
                                        {{--@endif--}}
                                        {{--@if(Auth::User()->can('CanTrackRoles'))--}}
                                        <td><a class="link" href='{{  url("/activities/$permission->id/Permission") }}'><i class="fa fa-road"></i></a></td>
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

                        {{ $permissions->links() }}

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
        var deletePermissionArray=[];

        $(document).on("change", ".checkbox1", function () {
            if(this.checked) {
                count=count+1;
                $("#trash").css("display", "block");
                //alert(this.value);
                deletePermissionArray.push(JSON.parse(this.value));
                //
                console.log(deletePermissionArray);
                //alert(count);
            }
            if(!this.checked){
                count=count-1;
                $("#selectAll").prop('checked',false);
                if(count==0){
                    $("#trash").css("display", "none");
                }
                var index=deletePermissionArray.indexOf(this.value);
                deletePermissionArray.splice(index, 1);
                console.log(deletePermissionArray);
                //alert(count);

            }
        });

        $(document).on("change", "#selectAll", function () {
            if(this.checked) {
                deletePermissionArray=[];
                $.each(JSON.parse(this.value), function(ky, loc) {
                    deletePermissionArray.push(loc);
                });

                //allID.push(this.value);
                //console.log(allID);
                $(".checkbox1").prop('checked',true);
                count=$("[type='checkbox']:checked").length-1;
                $("#trash").css("display", "block");
                //alert(count);
                console.log(deletePermissionArray);
            }
            if(!this.checked){
                deletePermissionArray=[];
                if(count==0){
                    $("#trash").css("display", "none");
                }
                $(".checkbox1").prop('checked',false);
                count=count-($("[type='checkbox']:not(:checked)").length-1);
                $("#trash").css("display", "none");
                //alert(count);
                console.log(deletePermissionArray);
            }


        });



        function deletePermissions(){
            $.ajax({
                url:"@php echo url('/deletepermissions') @endphp",
                type: "DELETE",
                data:{deletePermission:deletePermissionArray},
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
                error:function(){
                    alert("error!!!!");
                }
            });
            //return false;
        }


    </script>

    @endsection