<div class='modal fade' id='approveModal' role='dialog' aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class="modal-header">
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    &times;</button>
                <h4 class='modal-title'>Quotaion Approval</h4>
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

                <form id="approve" role="form" method="post">
                     {{ csrf_field() }}

                    <div class="form-group">
                        <label>Installation Lead</label>
                        <input id="inslead" type="text" class="form-control" name="inslead" autocomplete="off" required>

                    </div>

                    <div class="form-group input-group date {{ $errors->has('planned_delivery_date_time') ? ' has-error' : '' }}" style="width: 100%;">
                        <label>Planned Delivery Date Time</label>


                        <input id="planned_delivery_date_time" type="text" class="form-control" name="planned_delivery_date_time" required >

                        @if ($errors->has('planned_delivery_date_time'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('planned_delivery_date_time') }}</strong>
                                    </span>
                        @endif

                    </div>

                    {{--<div class="form-group input-group date {{ $errors->has('actual_visit_date_time') ? ' has-error' : '' }}" style="width: 100%;">--}}
                    {{--<label>Actual Visit Date Time</label>--}}


                    {{--<input id="actual_visit_date_time" type="text" class="form-control" name="actual_visit_date_time" required >--}}

                    {{--@if($errors->has('actual_visit_date_time'))--}}
                    {{--<span class="help-block">--}}
                    {{--<strong>{{ $errors->first('actual_visit_date_time') }}</strong>--}}
                    {{--</span>--}}
                    {{--@endif--}}

                    {{--</div>--}}

                    <div class="form-group">

                        <button id="btnApprove" name="btnApprove"  type="submit" class="btn btn-primary">
                            Approve
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

    $('#inslead').typeahead({
        source: function (query, result) {
            $.ajax({
                url:"@php echo url('/getinstallationleads') @endphp",
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
            $("#btnApprove").css("display", "block");
            return;
        }
    });

    $('#planned_delivery_date_time').datetimepicker({
        useCurrent:false,
        format: 'YYYY-MM-DD HH:mm:ss',
        sideBySide: true

    });

//    $('#actual_visit_date_time').datetimepicker({
//        useCurrent:false,
//        format: 'YYYY-MM-DD HH:mm:ss',
//        sideBySide: true
//
//    });

    $("#approve").submit(function(e) {

        $.ajax({
            type: "POST",
            url: approveUrl,
            data:$("#approve").serialize(),
            success: function(data)
            {
                //console.log(data);
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

    $('#inslead').on("keydown", function(e) {

        if (e.keyCode == 8 || e.keyCode == 46) {

            $("#btnApprove").css("display", "none");
            return;
        }

        $("#btnApprove").css("display", "none");
        return;


    });

</script>