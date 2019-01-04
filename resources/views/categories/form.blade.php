
    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Name</label>
        <div class="col-md-6">
        <input id="name" type="text" class="form-control" name="name" value="@if(old('name')){{ old('name')}}@else{{ $category->name or ''}}@endif" required autofocus>
        @if ($errors->has('name'))
            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
        @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Description</label>
        <div class="col-md-6">
        <textarea id="description" class="form-control" name="description">@if(old('description')){{ old('description')}}@else{{ $category->description or ''}}@endif</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label" ></label>
        <div class="col-md-6">
            <button type="submit" class="btn btn-success">
                <span class="glyphicon glyphicon-plus"></span>
                {{ $submitButtonText }}
            </button>
            <button type="reset" class="btn btn-danger pull-right">
                <span class="glyphicon glyphicon-remove-sign"></span>
                Clear
            </button>
        </div>

    </div>


