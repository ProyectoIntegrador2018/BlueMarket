<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
	<label for="name" class="control-label">{{ 'Name' }}</label>
	<input class="form-control" name="name" type="text" id="name" value="{{ isset($user->name) ? $user->name : ''}}" >
	{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
	<label for="email" class="control-label">{{ 'Email' }}</label>
	<input class="form-control" name="email" type="text" id="email" value="{{ isset($user->email) ? $user->email : ''}}" >
	{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('role') ? 'has-error' : ''}}">
	<label for="role" class="control-label">{{ 'Role' }}</label>
	<input class="form-control" name="role" type="number" id="role" value="{{ isset($user->role) ? $user->role : ''}}" >
	{!! $errors->first('role', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('picture_url') ? 'has-error' : ''}}">
	<label for="picture_url" class="control-label">{{ 'Picture Url' }}</label>
	<input class="form-control" name="picture_url" type="text" id="picture_url" value="{{ isset($user->picture_url) ? $user->picture_url : ''}}" >
	{!! $errors->first('picture_url', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
	<input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
