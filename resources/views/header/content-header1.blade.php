@if(Session::has('error'))
    <div id="error" class="col-md-8 alert alert-danger alert-dismissible" style="z-index:1;position:absolute;width: 50%;margin: 0 auto;left: 0;right: 0;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> {{ Session::get('error') }}</h4>
    </div>
@endif

@if(Session::has('success'))
    <div id="success" class="alert alert-success alert-dismissible" style="z-index:1;position:absolute;width: 50%;margin: 0 auto;left: 0;right: 0;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> {!! Session::get('success') !!}</h4>
    </div>
@endif

<div id="notdeleted" class="col-md-8 alert alert-danger alert-dismissible" style="z-index:1;position:absolute;width: 50%;margin: 0 auto;left: 0;right: 0;display:none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i id="notdeletedicon" class="icon fa fa-ban"></i></h4>
</div>

<div id="deleted" class="alert alert-success alert-dismissible" style="z-index:1;position:absolute;width: 50%;margin: 0 auto;left: 0;right: 0;display:none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i id="deletedicon" class="icon fa fa-check"></i></h4>
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