@if(Session::has('error'))
    <div id="error" class="alert bg-danger" role="alert" style="z-index:1;position:absolute;width: 50%;margin: 0 auto;left: 0;right: 0;top:50%;">
        <svg class="glyph stroked cancel">
            <use xlink:href="#stroked-cancel"></use>
        </svg>
        {{ Session::get('error') }}
        <a href="#" class="pull-right">
            <span class="glyphicon glyphicon-remove">
            </span>
        </a>
    </div>
@endif

@if(Session::has('success'))
    <div id="success" class="alert bg-success" role="alert" style="z-index:1;position:absolute;width: 50%;margin: 0 auto;left: 0;right: 0;top:50%;">
        <svg class="glyph stroked checkmark">
            <use xlink:href="#stroked-checkmark">
            </use>
        </svg>
        {!! Session::get('success') !!}
        <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

@endif

<div id="deleted" class="alert bg-success" role="alert" style="display:none;z-index:1;position:absolute;width: 50%;margin: 0 auto;left: 0;right: 0;top:50%;">
    <svg class="glyph stroked checkmark">
        <use xlink:href="#stroked-checkmark"></use>
    </svg>
    <a href="#" class="pull-right">
        <span class="glyphicon glyphicon-remove">
        </span>
    </a>
</div>

<div id="notdeleted" class="alert bg-danger" role="alert" style="display:none;z-index:1;position:absolute;width: 50%;margin: 0 auto;left: 0;right: 0;top:50%;">
    <svg class="glyph stroked cancel">
        <use xlink:href="#stroked-cancel"></use>
    </svg>
    <a href="#" class="pull-right">
        <span class="glyphicon glyphicon-remove">
        </span>
    </a>
</div>

@if(Session::has('warning'))
    <div id="warning" class="alert alert-warning alert-dismissible" style="z-index:1;position:absolute;width: 50%;margin: 0 auto;left: 0;right: 0;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-warning"></i>
        </h4>
        <ul>
            {!! Session::get('warning')  !!}
        </ul>
    </div>
@endif

<div class='modal fade' id='myModal' role='dialog'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class="modal-header">
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    &times;</button>
                <h4 class='modal-title'>Activity Log</h4>
            </div>
            <div class='modal-body'>

                <ul class='list-group'>

                </ul>

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-default pull-left' data-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>

<div class='modal fade' id='canNotRescheduleModal' role='dialog' aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class="modal-header">
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    &times;</button>
                <h4 class='modal-title'>Reschedule</h4>
            </div>
            <div class='modal-body'>

                <ul class='list-group'>

                </ul>

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-default pull-left' data-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>