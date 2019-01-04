@extends('layouts.app')

@section('content')

    @include ("header.content-header")
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Permission Role</li>
            <li class="active">Manage Assigned Permissions</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-6">
                            Manage Assigned Permissions
                        </div>
                        <div class="col-lg-6">

                            <form role="form" action="{{ url('/search/PermissionRole') }}" method="GET">
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

                    @if($getAssignedPermission->count() > 0)

                        <div style="padding-left:30%;">
                            <button id="trash" class="btn btn-default btn-sm" style="display:none;width:10%;height:15%;z-index:1;position: absolute;" onclick="deletePermissionRoles()" title="delete">
                                <svg class="glyph stroked trash"><use xlink:href="#stroked-trash"/></svg>
                            </button>
                        </div>
                        <div style="overflow-x:auto;">
                            <div style="float:right"><h1>Total:{{ $getAssignedPermission->total() }}</h1></div>
                            <table data-toggle="table" id="example2" data-row-style="rowStyle">
                                <thead>

                                <tr>
                                    <th>Select <input type="checkbox" id="selectAll" value="{{ $getAssignedPermissionIds->toJson() }}"></th>
                                    <th>Role Name</th>
                                    <th>Permission Name</th>
                                    <th>Track</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach ($getAssignedPermission as $urc)
                                    <tr>
                                        <td><input type="checkbox" class="checkbox1" value="{{ $urc->permissionrole_id }}"></td>
                                        <td>{{ $urc->role_name }}</td>
                                        <td>{{ $urc->permission_name }}</td>
                                        <td><a class="link" href='{{ url("/activities/$urc->id/PermissionRole") }}'><i class="fa fa-road"></i></a></td>

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

                        {{ $getAssignedPermission->links() }}

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
        var deletePermissionRoleArray=[];

        $(document).on("change", ".checkbox1", function () {
            if(this.checked) {
                count=count+1;
                $("#trash").css("display", "block");
                //alert(this.value);
                deletePermissionRoleArray.push(this.value);
                //
                console.log(deletePermissionRoleArray);
                //alert(count);
            }
            if(!this.checked){
                count=count-1;
                $("#selectAll").prop('checked',false);
                if(count==0){
                    $("#trash").css("display", "none");
                }
                var index=deletePermissionRoleArray.indexOf(this.value);
                deletePermissionRoleArray.splice(index, 1);
                console.log(deletePermissionRoleArray);
                //alert(count);

            }
        });

        $(document).on("change", "#selectAll", function () {
            if(this.checked) {
                //console.log(JSON.parse(this.value));
                deletePermissionRoleArray=[];
                $.each(JSON.parse(this.value), function(ky, loc) {
                    //console.log(loc[0]);
                    deletePermissionRoleArray.push(loc);
                });

                //allID.push(this.value);
                //console.log(allID);
                $(".checkbox1").prop('checked',true);
                count=$("[type='checkbox']:checked").length-1;
                $("#trash").css("display", "block");
                //alert(count);
                console.log(deletePermissionRoleArray);
            }
            if(!this.checked){
                deletePermissionRoleArray=[];
                if(count==0){
                    $("#trash").css("display", "none");
                }
                $(".checkbox1").prop('checked',false);
                count=count-($("[type='checkbox']:not(:checked)").length-1);
                $("#trash").css("display", "none");
                //alert(count);
                console.log(deletePermissionRoleArray);
            }


        });



        function deletePermissionRoles(){
            $.ajax({
                url:"@php echo url('/deletepermissionrole') @endphp",
                type: "DELETE",
                data:{deletePermissionRole:deletePermissionRoleArray},
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