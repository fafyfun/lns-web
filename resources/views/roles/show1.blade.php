@extends('layouts.app1')

@section('content')
    <section class="content-header">

        @include ("header.content-header1")


    </section>
    <section class="content">

        <div class="col-md-12">
            <div class="box box-info box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Manage Roles</h3>
                </div>



                <form class="form-horizontal" action="{{ url('/search/Role') }}" method="GET">

                    <!-- <div class="col-md-12"> -->
                    <!-- <div class="box box-info box-solid"> -->
                    <!-- <div class="box-body"> -->
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Keyword</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search By Name or Short Name" value="{{ $search or '' }}" >


                        </div>
                    </div>

                    <div class="btn-group" style="padding-left:17%;">
                        <button type="submit" name="search_submit" id="search_submit" class="btn btn-primary">Search</button>
                    </div>

                </form>
                </br>

                @if($roles->count() > 0)
                    @if(Auth::User()->can('CanDeleteRoles'))
                    <div class="btn-group" style="padding-left:30%;">
                        <button id="trash" class="btn btn-default btn-sm" style="display:none;z-index:1;position: absolute;" onclick="deleteRoles()" title="delete">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box-body">
                                <div style="overflow-x:auto;">
                                    <div style="float:right"><h1>Total:{{ $roles->total() }}</h1></div>
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>

                                    <tr>
                                        <th>Select <input type="checkbox" id="selectAll" value="{{ $collectionId->toJson() }}"></th>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Short Name</th>
                                        @if(Auth::User()->can('CanEditRoles'))
                                        <th>Action</th>
                                        @endif
                                        @if(Auth::User()->can('CanTrackRoles'))
                                        <th>Track</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @php
                                        $id=1;
                                    @endphp

                                    @foreach ($roles as $role)
                                    <tr>
                                        <td><input type="checkbox" class="checkbox1" value="{{ $role->id }}"></td>
                                        <td>{{ (($roles->currentPage()-1)*$roles->perPage())+$id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->shortname }}</td>
                                        @if(Auth::User()->can('CanEditRoles'))
                                        <td><a href='{{ url("/roles/$role->id/edit") }}'><i class="fa fa-edit"></i></a></td>
                                        @endif
                                            @if(Auth::User()->can('CanTrackRoles'))
                                        <td><a class= "link" href='{{  url("/activities/$role->id/Role") }}'><i class="fa fa-edit"></i></a></td>
                                        @endif
                                        @php $id++; @endphp
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                <table id="example3" class="table table-bordered table-hover">
                                    <tr>
                                        <td>No Result Found</td>
                                    </tr>
                                </table>
                                @endif
                                </div>


                                {{ $roles->links() }}
                            </div>

                        </div>
                    </div>


            </div>
        </div>

    </section>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.link').click(function(e){
            //alert('hi');
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
        var deleteRoleArray=[];

        $(".checkbox1").change(function() {
            if(this.checked) {
                count=count+1;
                $("#trash").css("display", "block");
                //alert(this.value);
                deleteRoleArray.push(JSON.parse(this.value));
                //
                console.log(deleteRoleArray);
                //alert(count);
            }
            if(!this.checked){
                count=count-1;
                $("#selectAll").prop('checked',false);
                if(count==0){
                    $("#trash").css("display", "none");
                }
                var index=deleteRoleArray.indexOf(this.value);
                deleteRoleArray.splice(index, 1);
                console.log(deleteRoleArray);
                //alert(count);

            }
        });

        $("#selectAll").change(function(){
            if(this.checked) {
                deleteRoleArray=[];
                $.each(JSON.parse(this.value), function(ky, loc) {
                    deleteRoleArray.push(loc);
                });

                //allID.push(this.value);
                //console.log(allID);
                $(".checkbox1").prop('checked',true);
                count=$("[type='checkbox']:checked").length-1;
                $("#trash").css("display", "block");
                //alert(count);
                console.log(deleteRoleArray);
            }
            if(!this.checked){
                deleteRoleArray=[];
                if(count==0){
                    $("#trash").css("display", "none");
                }
                $(".checkbox1").prop('checked',false);
                count=count-($("[type='checkbox']:not(:checked)").length-1);
                $("#trash").css("display", "none");
                //alert(count);
                console.log(deleteRoleArray);
            }


        });



        function deleteRoles(){
            $.ajax({
                url:"@php echo url('/deleteroles') @endphp",
                type: "DELETE",
                data:{deleteRole:deleteRoleArray},
                dataType: 'json',
                success: function (result){

                    console.log(result);

                    if(result.status == 1){
                        $("#deleted").css("display", "block");
                        $("#deletedicon").text(result.msg);
                        $("#deleted").fadeOut(3000,function(){
                            location.reload();
                        });

                    }else{
                        $("#notdeleted").css("display", "block");
                        $("#notdeletedicon").text(result.msg);
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