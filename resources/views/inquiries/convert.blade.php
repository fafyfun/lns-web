<div class='modal fade' id='convert_to_inquiry' role='dialog' aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class="modal-header">
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    &times;</button>
                <h4 class='modal-title'>Convert To Inquiry</h4>
            </div>
            <div class='modal-body'>

                <div id="ajaxsuccess" class="alert bg-success" role="alert" style="display:none;z-index:1000;position:absolute;width: 50%;margin: 0 auto;left: 0;right: 0;top:30%;">
                    <svg class="glyph stroked checkmark">
                        <use xlink:href="#stroked-checkmark">
                        </use>
                    </svg>
                    <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                </div>

                <div id="ajaxerror" class="alert bg-danger" role="alert" style="display:none;z-index:1000;position:absolute;width: 50%;margin: 0 auto;left: 0;right: 0;top:30%;">
                    <svg class="glyph stroked cancel">
                        <use xlink:href="#stroked-cancel"></use>
                    </svg>
                    <a href="#" class="pull-right">
                    <span class="glyphicon glyphicon-remove">
                    </span>
                    </a>
                </div>

                <form id="convert" role="form" method="post">
                    {{ csrf_field() }}

                <div class="form-group">
                    <label>Agent</label>
                    <input id="agent" type="text" class="form-control" name="agent" autocomplete="off">

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

                {{--<div class="form-group {{ $errors->has('inquiry_source') ? ' has-error' : '' }}">--}}
                    {{--<label>Inquiry Source</label>--}}


                    {{--<input id="inquiry_source" type="text" class="form-control" name="inquiry_source" value="@if(old('inquiry_source')){{ old('inquiry_source')}}@endif" required >--}}

                    {{--@if ($errors->has('inquiry_source'))--}}
                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('inquiry_source') }}</strong>--}}
                                    {{--</span>--}}
                    {{--@endif--}}

                {{--</div>--}}

                <div class="form-group {{ $errors->has('maximum_discount') ? ' has-error' : '' }}">
                    <label>Maximum Discount(%)</label>


                    <input id="maximum_discount" type="text" class="form-control" name="maximum_discount" value="@if(old('maximum_discount')){{ old('maximum_discount')}}@endif" required >

                    @if ($errors->has('maximum_discount'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('maximum_discount') }}</strong>
                                    </span>
                    @endif

                </div>

                <div class="form-group input-group date {{ $errors->has('actual_visit_date_time') ? ' has-error' : '' }}" style="width: 100%;">
                    <label>Actual Visit Date Time</label>


                    <input id="actual_visit_date_time" type="text" class="form-control" name="actual_visit_date_time" required >

                    @if ($errors->has('actual_visit_date_time'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('actual_visit_date_time') }}</strong>
                                    </span>
                    @endif

                </div>

                <div class="form-group">

                    <button id="inquiry" name="inquiry" value="inquiry" type="submit" class="btn btn-primary" style="display: none;">
                        convert
                    </button>

                </div>

                </form>

            </div>
            {{--<div class='modal-footer'>--}}
                {{--<button type='button' class='btn btn-default pull-left' data-dismiss='modal'>Close</button>--}}
            {{--</div>--}}
        </div>
    </div>
</div>



<script>

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
            $("#inquiry").css("display", "block");
            return;
        }
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

    $('#maximum_discount').keyup(function () {
        this.value = this.value.replace(/[^\d+$]/,''); //only take whole numbers
    });

    $("#convert").submit(function(e) {

        $.ajax({
            type: "POST",
            url: convertInquiryUrl,
            data:$("#convert").serialize(),
            success: function(data)
            {
                if(data.success != undefined ){

                    $("#ajaxsuccess").css("display", "block");
                    $("#ajaxsuccess").text(data.success);
                    $("#ajaxsuccess").fadeOut(3000,function(){
                        location.reload();
                    });
                    return;

                }

                if(data.error != undefined ){

                    $("#ajaxerror").css("display", "block");
                    $("#ajaxerror").text(data.error);
                    $("#ajaxerror").fadeOut(3000,function(){
                        location.reload();
                    });
                    return;

                }
            }
        });

        e.preventDefault();
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