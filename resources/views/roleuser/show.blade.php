@extends('layouts.app1')

@section('content')
    <section class="content-header">
        @include ("header.content-header1")
    </section>
    <section class="content">

        <div class="col-md-12">
            <div class="box box-info box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Manage User Assigned Roles</h3>
                </div>



                <form class="form-horizontal" action="{{ url('/search/RoleUser') }}" method="GET">

                    <!-- <div class="col-md-12"> -->
                    <!-- <div class="box box-info box-solid"> -->
                    <!-- <div class="box-body"> -->
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Keyword</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search By User Name or User Email or Role" value="{{ $search or '' }}" >


                        </div>
                    </div>

                    <div class="btn-group" style="padding-left:17%;">
                        <button type="submit" name="search_submit" id="search_submit" class="btn btn-info">Search</button>
                    </div>

                </form>
                </br>

                @if($getUserAssignedRole->count() > 0)
                    <div class="btn-group" style="padding-left:30%;">
                        <button id="trash" class="btn btn-default btn-sm" style="display:none;z-index:1;position: absolute;" onclick="deleteUserRoles()" title="delete">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </div>


                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box-body">
                                <div style="overflow-x:auto;">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>

                                    <tr>
                                        <th>Select <input type="checkbox" id="selectAll" value="{{ $getUserAssignedRoleIds->toJson() }}"></th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>Role Name</th>
                                        @if(Auth::User()->can('CSA'))
                                        <th>Track</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>



                                    @foreach ($getUserAssignedRole as $urc)
                                    <tr>
                                        <td><input type="checkbox" class="checkbox1" value="{{ $urc->roleuser_id }}"></td>
                                        <td>{{ $urc->user_name }}</td>
                                        <td>{{ $urc->email }}</td>
                                        <td>{{ $urc->role_name }}</td>
                                        @if(Auth::User()->can('CSA'))
                                        <td><a class="link" href='{{ url("/activities/$urc->id/RoleUser") }}'><i class="fa fa-edit"></i></a></td>
                                        @endif
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


                                {{ $getUserAssignedRole->links() }}
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
        var deleteRoleUserArray=[];

        $(".checkbox1").change(function() {
            if(this.checked) {
                count=count+1;
                $("#trash").css("display", "block");
                //alert(this.value);
                deleteRoleUserArray.push(this.value);
                //
                console.log(deleteRoleUserArray);
                //alert(count);
            }
            if(!this.checked){
                count=count-1;
                $("#selectAll").prop('checked',false);
                if(count==0){
                    $("#trash").css("display", "none");
                }
                var index=deleteRoleUserArray.indexOf(this.value);
                deleteRoleUserArray.splice(index, 1);
                console.log(deleteRoleUserArray);
                //alert(count);

            }
        });

        $("#selectAll").change(function(){
            if(this.checked) {
            //console.log(JSON.parse(this.value));
                deleteRoleUserArray=[];
                $.each(JSON.parse(this.value), function(ky, loc) {
                    //console.log(loc[0]);
                    deleteRoleUserArray.push(loc);
                });

                //allID.push(this.value);
                //console.log(allID);
                $(".checkbox1").prop('checked',true);
                count=$("[type='checkbox']:checked").length-1;
                $("#trash").css("display", "block");
                //alert(count);
                console.log(deleteRoleUserArray);
            }
            if(!this.checked){
                deleteRoleUserArray=[];
                if(count==0){
                    $("#trash").css("display", "none");
                }
                $(".checkbox1").prop('checked',false);
                count=count-($("[type='checkbox']:not(:checked)").length-1);
                $("#trash").css("display", "none");
                //alert(count);
                console.log(deleteRoleUserArray);
            }


        });



        function deleteUserRoles(){
            $.ajax({
                url:"@php echo url('/deleteroleuser') @endphp",
                type: "DELETE",
                data:{deleteRoleUser:deleteRoleUserArray},
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
                error:function(){
                    alert("error!!!!");
                }
            });
            //return false;
        }


    </script>

    @endsection