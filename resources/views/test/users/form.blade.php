<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
	<label for="name" class="control-label">{{ 'Name' }}</label>
	<input class="form-control" name="name" type="text" id="name" value="{{ isset($user->name) ? $user->name : ''}}" >
	{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('role') ? 'has-error' : ''}}">
	<label for="role" class="control-label">{{ 'Role' }}</label>
	<input class="form-control" name="role" type="number" id="role" value="{{ isset($user->role) ? $user->role : ''}}" >
	{!! $errors->first('role', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
	<input class="ui primary button btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
