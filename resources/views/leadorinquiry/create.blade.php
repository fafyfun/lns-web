@extends('layouts.app')

@section('content')
    @include ("header.content-header")
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Sales Leads</li>
            <li class="active">Add Lead/Inquiry</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Lead/Inquiry</div>
                <div class="panel-body">
                    <div class="col-md-8 col-md-offset-2">
                    <form class="form-horizontal" role="form" action="{{ url('/leadorinquiry') }}" method="post" novalidate>
                        {{ csrf_field() }}

                        <div id="customerInformation">

                            <div class="form-group">
                                <legend>Customer Informations</legend>
                                {{--<label>Customer Informations</label>--}}
                            </div>


                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">


                                <label class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" autocomplete="off" value="@if(old('email')){{ old('email')}}@endif" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                </div>

                            </div>

                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Name</label>
                                <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="@if(old('name')){{ old('name')}}@endif" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                </div>

                            </div>

                            <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Address</label>
                                <div class="col-md-6">
                                <textarea id="address" class="form-control" name="address">@if(old('address')){{ old('address')}}@endif</textarea>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                                </div>

                            </div>

                            <div class="form-group {{ $errors->has('mobile') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Mobile No</label>

                                <div class="col-md-6">
                                <input id="mobile" type="text" class="form-control" name="mobile" value="@if(old('mobile')){{ old('mobile')}}@endif" required >

                                @if ($errors->has('mobile'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                                </div>

                            </div>

                            <div class="form-group {{ $errors->has('telephone') ? ' has-error' : '' }}">

                                <label class="col-md-4 control-label">Telephone No</label>
                                <div class="col-md-6">
                                <input id="telephone" type="text" class="form-control" name="telephone" value="@if(old('telephone')){{ old('telephone')}}@endif">
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" ></label>
                                <div class="col-md-6">
                                <button id="customer" name="customer" type="submit" class="btn btn-success" value="customer">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    Sales Lead
                                </button>
                                <button id="create_inquiry" name="create_inquiry" type="button" class="btn btn-success" value="create_inquiry">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    Inquiry
                                </button>
                                </div>

                            </div>


                        </div>


                        <div id="inquiryInformation" style="display: none;">

                            <div class="form-group">
                                <legend>Inquiry Informations</legend>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Agent</label>
                                <div class="col-md-6">
                                <input id="agent" type="text" class="form-control" name="agent" autocomplete="off">
                                </div>

                            </div>

                            <div class="form-group input-group date {{ $errors->has('planned_visit_date_time') ? ' has-error' : '' }}" style="width: 105%;">
                                <label class="col-md-4 control-label">Planned Visit Date Time</label>

                                <div class="col-md-6">
                                <input id="planned_visit_date_time" type="text" class="form-control" name="planned_visit_date_time" required >

                                @if ($errors->has('planned_visit_date_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('planned_visit_date_time') }}</strong>
                                    </span>
                                @endif
                                </div>

                            </div>

                            {{--<div class="form-group {{ $errors->has('inquiry_source') ? ' has-error' : '' }}">--}}
                                {{--<label class="col-md-4 control-label">Inquiry Source</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<select id="inquiry_source" name="inquiry_source" class="form-control select2">--}}
                                        {{--<option value=''>--Select--</option>--}}
                                        {{--<option value='1' @if(old('inquiry_source')=='1') selected @endif>Internal</option>--}}
                                        {{--<option value='2' @if(old('inquiry_source')=='2') selected @endif>External</option>--}}
                                    {{--</select>--}}
                                {{--<input id="inquiry_source" type="text" class="form-control" name="inquiry_source" value="@if(old('inquiry_source')){{ old('inquiry_source')}}@endif" required >--}}

                                {{--@if ($errors->has('inquiry_source'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('inquiry_source') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                                {{--</div>--}}

                            {{--</div>--}}

                            <div class="form-group {{ $errors->has('maximum_discount') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Maximum Discount</label>

                                <div class="col-md-6">
                                <input id="maximum_discount" type="text" class="form-control" name="maximum_discount" value="@if(old('maximum_discount')){{ old('maximum_discount')}}@endif" required >

                                @if ($errors->has('maximum_discount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('maximum_discount') }}</strong>
                                    </span>
                                @endif
                                </div>

                            </div>

{{--                            <div class="form-group input-group date {{ $errors->has('actual_visit_date_time') ? ' has-error' : '' }}" style="width: 105%;">
                                <label class="col-md-4 control-label">Actual Visit Date Time</label>

                                <div class="col-md-6">
                                <input id="actual_visit_date_time" type="text" class="form-control" name="actual_visit_date_time" required >

                                @if ($errors->has('actual_visit_date_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('actual_visit_date_time') }}</strong>
                                    </span>
                                @endif
                                </div>

                            </div>--}}

                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                <button id="inquiry" name="inquiry" value="inquiry" type="submit" class="btn btn-success" style="display: none;">
                                    Done
                                </button>
                                </div>

                            </div>

                        </div>

                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $("#success").fadeOut(5000);
        $("#error").fadeOut(5000);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

            $('#email').typeahead({
                source: function (query, result) {
                    $.ajax({
                        url:"@php echo url('/getCustomerEmails') @endphp",
                        data: 'query=' + query,
                        dataType: "json",
                        type: "POST",
                        success: function (data) {
                            result($.map(data, function (item) {
                                return item;
                            }));
                        }
                    });
                },
                afterSelect:function (item) {
                    $.ajax({
                        url:"@php echo url('/getCustomerDetails') @endphp",
                        data: 'email='+ item,
                        dataType: "json",
                        type: "POST",
                        success: function (data) {

                            $('#name').val(data.data[0].name);
                            $('#address').val(data.data[0].address);
                            $('#mobile').val(data.data[0].mobile);
                            $('#telephone').val(data.data[0].telephone);
                        }
                    });
                }
            });

        $('#agent').typeahead({
            source: function (query, result) {
                $.ajax({
                    url:"@php echo url('/getAgents') @endphp",
                    data: 'query=' + query,
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
                        console.log(data);
                        result($.map(data, function (item) {
                            return item;
                        }));
                    }
                });
            },
            afterSelect:function (item) {
                $("#inquiry").css("display", "block");
                return;
            }
        });



        $("#create_inquiry").click(function(){

            $("#inquiryInformation").css("display", "block");
            $("#customer").css("display", "none");
            $("#create_inquiry").css("display", "none");
        });

        $('#planned_visit_date_time').datetimepicker({
            useCurrent:false,
            format: 'YYYY-MM-DD HH:mm:ss',
            sideBySide: true

        });

        $('#actual_visit_date_time').datetimepicker({
            useCurrent:false,
            format: 'YYYY-MM-DD HH:mm:ss',
            sideBySide: true

        });

        $('#mobile').keyup(function () {
            this.value = this.value.replace(/[^\d+$]/,''); //only take whole numbers
            //this.value = this.value.replace(/[^0-9\.]/g,'');
            //$('#qtyerror').text('');
        });

        $('#telephone').keyup(function () {
            this.value = this.value.replace(/[^\d+$]/,''); //only take whole numbers
        });

        $('#maximum_discount').keyup(function () {
            this.value = this.value.replace(/[^\d+$]/,''); //only take whole numbers
        });

        $('#agent').on("keydown", function(e) {

            if (e.keyCode == 8 || e.keyCode == 46) {

                $("#inquiry").css("display", "none");
                return;
            }

            $("#inquiry").css("display", "none");
            return;


        });

    </script>

@endsection