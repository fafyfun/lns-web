@extends('layouts.app')

@section('content')
    @include ("header.content-header")
    <div class="row">
        <ol class="breadcrumb">
            <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
            <li>Sales Target</li>
            <li class="active">Create Target</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create Sales Target</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <form class="form-horizontal" role="form" action="{{ url('/salestarget') }}" method="post">
                            {{ csrf_field() }}
                            <fieldset>
                                <div class="form-group {{ $errors->has('agent') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label">Agent</label>
                                    <div class="col-md-4">
                                        <input autocomplete="off" id="agent" type="text" class="form-control" name="agent" value="@if(old('agent')){{ old('agent')}}@else{{ $salestarget->name or ''}}@endif" required autofocus>
                                        @if ($errors->has('agent'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('agent') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('year') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label">Year</label>
                                    <div class="col-md-4">
                                        <input id="year" type="text" class="form-control" name="year" value="@if(old('year')){{ old('year')}}@else{{ $salestarget->year or ''}}@endif" required autofocus>
                                        @if ($errors->has('year'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('target') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label" for="Name (Full name)">Targets</label>
                                    <div class="col-md-10">
                                        <table data-toggle="table" data-row-style="rowStyle">
                                            <thead>
                                            <tr>
                                                <th>APR</th>
                                                <th>MAY</th>
                                                <th>JUN</th>
                                                <th>JUL</th>
                                                <th>AUG</th>
                                                <th>SEP</th>

                                            </tr>
                                            </thead>
                                            <tr>
                                                <td><input id="target" name="target[4]" type="text" placeholder="" class="form-control"></td>
                                                <td><input id="target" name="target[5]" type="text" placeholder="" class="form-control"></td>
                                                <td><input id="target" name="target[6]" type="text" placeholder="" class="form-control"></td>
                                                <td><input id="target" name="target[7]" type="text" placeholder="" class="form-control"></td>
                                                <td><input id="target" name="target[8]" type="text" placeholder="" class="form-control"></td>
                                                <td><input id="target" name="target[9]" type="text" placeholder="" class="form-control"></td>

                                            </tr>

                                        </table>

                                    </div>

                                    <label class="col-md-2 control-label" for="Name (Full name)"></label>
                                    <div class="col-md-10">
                                        <table data-toggle="table" data-row-style="rowStyle">
                                            <thead>
                                            <tr>

                                                <th>OCT</th>
                                                <th>NOV</th>
                                                <th>DEC</th>
                                                <th>JAN</th>
                                                <th>FEB</th>
                                                <th>MAR</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td><input id="target" name="target[10]" type="text" placeholder="" class="form-control"></td>
                                                <td><input id="target" name="target[11]" type="text" placeholder="" class="form-control"></td>
                                                <td><input id="target" name="target[12]" type="text" placeholder="" class="form-control"></td>
                                                <td><input id="target" name="target[1]" type="text" placeholder="" class="form-control"></td>
                                                <td><input id="target" name="target[2]" type="text" placeholder="" class="form-control"></td>
                                                <td><input id="target" name="target[3]" type="text" placeholder="" class="form-control"></td>
                                            </tr>

                                        </table>
                                        @if ($errors->has('target'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('target') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" ></label>
                                    <div class="col-md-10">
                                        <button id='createtarget' name='createtarget'type="submit" class="btn btn-success">
                                            <span class="glyphicon glyphicon-plus"></span>
                                            Create
                                        </button>
                                        <button id='resettarget' name='resettarget' type="reset" class="btn btn-danger pull-right">
                                            <span class="glyphicon glyphicon-remove-sign"></span>
                                            Clear
                                        </button>
                                    </div>

                                </div>
                            </fieldset>
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
                $("#createtarget").css("display", "block");
                $("#resettarget").css("display", "block");
                return;
            }
        });

        $('#agent').on("keydown", function(e) {

//            if (e.keyCode == 8 || e.keyCode == 46) {
//
//                $("#createtarget").css("display", "none");
//                return;
//            }

            $("#createtarget").css("display", "none");
            $("#resettarget").css("display", "none");
            return;


        });

    </script>

@endsection