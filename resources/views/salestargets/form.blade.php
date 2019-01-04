
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

<div class="form-group">
    <label class="col-md-2 control-label">Year</label>
    <div class="col-md-4">
        <input id="year" type="text" class="form-control" name="year" value="@if(old('year')){{ old('year')}}@else{{ $salestarget->year or ''}}@endif" required autofocus>
    </div>
</div>

<div class="form-group {{ $errors->has('target') ? ' has-error' : '' }}"">
    <label class="col-md-2 control-label" for="Name (Full name)">Targets</label>
    <div class="col-md-10">
        <table data-toggle="table" class="table">
            <thead>
            <tr>
                <th data-field="emp-id">APR</th>
                <th data-field="firstname">MAY</th>
                <th data-field="lastname">JUN</th>
                <th data-field="user-dob">JUL</th>
                <th data-field="user-phone">AUG</th>
                <th data-field="user-email">SEP</th>
                <th data-field="user-gen">OCT</th>
                <th data-field="user-role">NOV</th>
                <th data-field="user-role">DEC</th>
                <th data-field="user-role">JAN</th>
                <th data-field="user-role">FEB</th>
                <th data-field="user-role">MAR</th>
            </tr>
            </thead>
            <tr>
                <td><input id="target" name="target[]" type="text" placeholder="" class="form-control"></td>
                <td><input id="target" name="target[]" type="text" placeholder="" class="form-control"></td>
                <td><input id="target" name="target[]" type="text" placeholder="" class="form-control"></td>
                <td><input id="target" name="target[]" type="text" placeholder="" class="form-control"></td>
                <td><input id="target" name="target[]" type="text" placeholder="" class="form-control"></td>
                <td><input id="target" name="target[]" type="text" placeholder="" class="form-control"></td>
                <td><input id="target" name="target[]" type="text" placeholder="" class="form-control"></td>
                <td><input id="target" name="target[]" type="text" placeholder="" class="form-control"></td>
                <td><input id="target" name="target[]" type="text" placeholder="" class="form-control"></td>
                <td><input id="target" name="target[]" type="text" placeholder="" class="form-control"></td>
                <td><input id="target" name="target[]" type="text" placeholder="" class="form-control"></td>
                <td><input id="target" name="target[]" type="text" placeholder="" class="form-control"></td>
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
            {{ $submitButtonText }}
        </button>
        <button id='resettarget' name='resettarget' type="reset" class="btn btn-danger pull-right">
            <span class="glyphicon glyphicon-remove-sign"></span>
            Clear
        </button>
    </div>

</div>


