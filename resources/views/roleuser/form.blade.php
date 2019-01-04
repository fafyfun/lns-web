<div class="box-body">

    <div class="form-group{{ $errors->has('user') ? ' has-error' : '' }}">
        <label for="status" class="col-sm-2 control-label">User</label>

        <div class="col-sm-4">
            <select id="user" name="user" class="form-control select2" {{ $dropDownStatus or '' }}>
                <option value='' >--Select--</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}" @if(old('user') == $user->id ) selected @else @if(isset($userId) && $userId==$user->id) selected @endif @endif >{{ $user->email }}</option>
                    @endforeach
            </select>

            @if ($errors->has('user'))
                <span class="help-block">
                                        <strong>{{ $errors->first('user') }}</strong>
                                    </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
        <label for="status" class="col-sm-2 control-label">Role</label>

        <div class="col-sm-4">
            <select id="role" name="role" class="form-control select2">
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

    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <button type="submit" class="btn btn-primary">
                {{ $submitButtonText }}
            </button>
        </div>
    </div>



</div>