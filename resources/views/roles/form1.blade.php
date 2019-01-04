<div class="box-body">

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name" class="col-sm-2 control-label">Name</label>

        <div class="col-sm-4">
            <input id="name" type="text" class="form-control" name="name" value="@if(old('name')){{ old('name')}}@else{{ $role->name or ''}}@endif" required autofocus>

            @if ($errors->has('name'))
                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('shortname') ? ' has-error' : '' }}">
        <label for="name" class="col-sm-2 control-label">Short Name</label>

        <div class="col-sm-4">
            <input id="shortname" type="text" class="form-control" name="shortname" value="@if(old('shortname')){{ old('shortname')}}@else{{ $role->shortname or ''}}@endif" required >

            @if ($errors->has('shortname'))
                <span class="help-block">
                                        <strong>{{ $errors->first('shortname') }}</strong>
                                    </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
        <label for="email" class="col-sm-2 control-label">Description</label>

        <div class="col-sm-4">
            <textarea id="description" class="form-control" name="description">@if(old('description')){{ old('description')}}@else{{ $role->description or ''}}@endif</textarea>

            @if ($errors->has('description'))
                <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <button type="submit" class="btn btn-primary">
                {{ $submitButtonText }}
            </button>
        </div>
    </div>


</div>