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
        <div class="col-lg-12">
            <h1 class="page-header">Add Lead/Inquiry</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Lead/Inquiry</div>
                <div class="panel-body">
                    <form role="form" action="{{ url('/salesleads') }}" method="post" novalidate>
                        {{ csrf_field() }}

                        <div id="customerInformation">

                            <div class="form-group">
                                <legend>Customer Informations</legend>
                                {{--<label>Customer Informations</label>--}}
                            </div>


                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">


                                <label>E-Mail Address</label>


                                <input id="email" type="email" class="form-control" name="email" autocomplete="off" value="@if(old('email')){{ old('email')}}@endif" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label>Name</label>
                                <input id="name" type="text" class="form-control" name="name" value="@if(old('name')){{ old('name')}}@endif" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                                <label>Address</label>
                                <textarea id="address" class="form-control" name="address">@if(old('address')){{ old('address')}}@endif</textarea>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-group {{ $errors->has('mobile') ? ' has-error' : '' }}">
                                <label>Mobile No</label>


                                <input id="mobile" type="text" class="form-control" name="mobile" value="@if(old('mobile')){{ old('mobile')}}@endif" required >

                                @if ($errors->has('mobile'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-group {{ $errors->has('telephone') ? ' has-error' : '' }}">

                                <label>Telephone No</label>
                                <input id="telephone" type="text" class="form-control" name="telephone" value="@if(old('telephone')){{ old('telephone')}}@endif">


                            </div>

                            <div class="form-group">

                                <button id="customer" name="customer" type="submit" class="btn btn-primary" value="customer">
                                    Create Inquiry Later
                                </button>

                                <button id="create_inquiry" name="create_inquiry" type="button" class="btn btn-primary" value="create_inquiry">
                                    Create Inquiry Now
                                </button>

                            </div>


                        </div>


                        <div id="inquiryInformation" style="display: none;">

                            <div class="form-group">
                                <legend>Inquiry Informations</legend>
                            </div>

                            <div class="form-group">
                                <label>Agent</label>
                                <input id="agent" type="text" class="form-control" name="agent">

                            </div>

                            <div class="form-group input-group date {{ $errors->has('planned_visit_date_time') ? ' has-error' : '' }}" style="width: 100%;">
                                <label>Planned Visit Date Time</label>


                                <input id="planned_visit_date_time" type="text" class="form-control" name="planned_visit_date_time" required >

                                @if ($errors->has('planned_visit_date_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('planned_visit_date_time') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-group {{ $errors->has('inquiry_source') ? ' has-error' : '' }}">
                                <label>Inquiry Source</label>


                                <input id="inquiry_source" type="text" class="form-control" name="inquiry_source" value="@if(old('inquiry_source')){{ old('inquiry_source')}}@endif" required >

                                @if ($errors->has('inquiry_source'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('inquiry_source') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-group {{ $errors->has('maximum_discount') ? ' has-error' : '' }}">
                                <label>Maximum Discount</label>


                                <input id="maximum_discount" type="text" class="form-control" name="maximum_discount" value="@if(old('maximum_discount')){{ old('maximum_discount')}}@endif" required >

                                @if ($errors->has('maximum_discount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('maximum_discount') }}</strong>
                                    </span>
                                @endif

                            </div>

                            {{--<div class="form-group input-group date {{ $errors->has('actual_visit_date_time') ? ' has-error' : '' }}" style="width: 100%;">--}}
                                {{--<label>Actual Visit Date Time</label>--}}


                                {{--<input id="actual_visit_date_time" type="text" class="form-control" name="actual_visit_date_time" required >--}}

                                {{--@if ($errors->has('actual_visit_date_time'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('actual_visit_date_time') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}

                            {{--</div>--}}

                            <div class="form-group">

                                <button id="inquiry" name="inquiry" value="inquiry" type="submit" class="btn btn-primary">
                                    Done
                                </button>

                            </div>

                        </div>



                    </form>
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

    </script>

@endsection