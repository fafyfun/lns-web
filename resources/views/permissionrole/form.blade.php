
    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Role</label>
        <div class="col-md-6">
            <select id="role" name="role" class="form-control">
                <option value='' >--Select--</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @if(old('role') == $role->id ) selected @else @if(isset($roleId) && $roleId==$role->id) selected @endif @endif>{{ $role->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('role'))
                <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('permission') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Permission</label>
                @if ($permissions->count() > 0)
                <div class="col-md-6"><input type="checkbox" id="selectAll" value="{{ $permissions->pluck('id')->toJson() }}">All</div>
                @endif
            <div class="col-md-6">
                @foreach ($permissions as $permission)
                <div><input type="checkbox" class="checkbox1" id="permission" name="permission[{{ $permission->id }}]" value="{{ $permission->id }}" @if(array_key_exists($permission->id, old('permission', []))) checked @else @if(isset($permissionId) && $permissionId==$permission->id) checked @endif @endif >{{ $permission->name }} </div>
                @endforeach
                @if ($errors->has('permission'))
                    <span class="help-block">
                                            <strong>{{ $errors->first('permission') }}</strong>
                                        </span>
                @endif
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




