<!-- Name -->
<div class="field {{ $errors->has('name') ? 'has-error' : ''}}">
	<label for="name" class="control-label">{{ 'Name' }}</label>
	<input class="form-control" name="name" type="text" id="name" value="{{ isset($user->name) ? $user->name : ''}}" >
	{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<!-- Email -->
<div class="field {{ $errors->has('email') ? 'has-error' : ''}}">
	<label for="email" class="control-label">{{ 'Email' }}</label>
	<input class="form-control" name="email" type="text" id="email" value="{{ isset($user->email) ? $user->email : ''}}" >
	{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<!-- Role -->
<div class="field {{ $errors->has('role') ? 'has-error' : ''}}">
	<label for="role" class="control-label">{{ 'Role' }}</label>
	<input class="form-control" name="role" type="number" id="role" value="{{ isset($user->role) ? $user->role : ''}}" >
	{!! $errors->first('role', '<p class="help-block">:message</p>') !!}
</div>

<br />
