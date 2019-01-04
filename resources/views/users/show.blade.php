@extends('layouts.app')

@section('content')

    @include ("header.content-header")
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Users</li>
            <li class="active">Manage User</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-3">
                            Manage User
                        </div>
                        <div class="col-lg-6">

                            <form role="form" action="{{ url('/search/User') }}" method="GET">
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


                    @if($users->count() > 0)

                        {{--<div style="padding-left:30%;">--}}
                            {{--<button id="trash" class="btn btn-default btn-sm" style="display:none;width:10%;height:15%;z-index:1;position: absolute;" onclick="deleteRoles()" title="delete">--}}
                                {{--<svg class="glyph stroked trash"><use xlink:href="#stroked-trash"/></svg>--}}
                            {{--</button>--}}
                        {{--</div>--}}

                        {{--<br>--}}
                        {{--<br>--}}
                        {{--<br>--}}
                        <div style="overflow-x:auto;">
                            <div style="float:right"><h1>Total:{{ $users->total() }}</h1></div>
                            <table data-toggle="table" id="example2" data-row-style="rowStyle">
                                <thead>

                                <tr>
                                    <th>Select <input type="checkbox" id="selectAll" value="{{ $collectionId->toJson() }}"></th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Last Login</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Track</th>
                                </tr>
                                </thead>

                                <tbody>

                                @php
                                    $id=1;
                                @endphp

                                @foreach ($users as $user)
                                    <tr>
                                        <td><input type="checkbox" class="checkbox1" value="{{ $user->id }}"></td>
                                        <td>{{ (($users->currentPage()-1)*$users->perPage())+$id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->phone_number }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>@if($user->last_login!=null){{ Carbon\Carbon::parse($user->last_login)->diffForHumans() }}@else Never logged In @endif</td>
                                        <td>{{ ($user->status == 'A') ? 'Active' : 'Deactive' }}</td>
                                        <td><a href='{{ url("/users/$user->id/edit") }}'><i class="fa fa-edit"></i></a></td>
                                        <td><a class="link" href='{{ url("/activities/$user->id/User") }}'><i class="fa fa-road"></i></a></td>
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

                        {{ $users->links() }}

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

//        function getActivities(e){
//
//            e.preventDefault();
//
//            var url = e.target.href;
//
//            $.ajax({
//                url: url,
//                type: "GET",
//                dataType: 'html',
//                success: function (result){
//
//                    console.log(result);
//
//                    $('.list-group').html(result);
//                    $("#myModal").modal('show');
//
//
//                },
//                error:function(){
//                    alert("error!!!!");
//                }
//            });
//
//        }


        $("#success").fadeOut(5000);
        $("#error").fadeOut(5000);

        var count=0;
        var deleteUserArray=[];

        $(document).on("change", ".checkbox1", function () {
            if(this.checked) {
                count=count+1;
                $("#trash").css("display", "block");
                //alert(this.value);
                deleteUserArray.push(JSON.parse(this.value));
                //
                //console.log(deleteUserArray);
                //alert(count);
            }
            if(!this.checked){
                count=count-1;
                $("#selectAll").prop('checked',false);
                if(count==0){
                    $("#trash").css("display", "none");
                }
                var index=deleteUserArray.indexOf(this.value);
                deleteUserArray.splice(index, 1);
                //console.log(deleteUserArray);
                //alert(count);

            }
        });

        $(document).on("change", "#selectAll", function () {
            if(this.checked) {
                deleteUserArray=[];
                $.each(JSON.parse(this.value), function(ky, loc) {
                    deleteUserArray.push(loc);
                });

                //allID.push(this.value);
                //console.log(allID);
                $(".checkbox1").prop('checked',true);
                count=$("[type='checkbox']:checked").length-1;
                $("#trash").css("display", "block");
                //alert(count);
                //console.log(deleteUserArray);
            }
            if(!this.checked){
                deleteUserArray=[];
                if(count==0){
                    $("#trash").css("display", "none");
                }
                $(".checkbox1").prop('checked',false);
                count=count-($("[type='checkbox']:not(:checked)").length-1);
                $("#trash").css("display", "none");
                //alert(count);
                //console.log(deleteUserArray);
            }


        });



        function deleteUsers(){
            $.ajax({
                url: "deleteusers",
                type: "DELETE",
                data:{deleteUser:deleteUserArray},
                dataType: 'json',
                success: function (result){

                    console.log(result);

                    if(result.status == 1){
                        $("#deleted").css("display", "block");
                        $("#deleted").fadeOut(3000,function(){
                            location.reload();
                        });

                    }else{
                        $("#notdeleted").css("display", "block");
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