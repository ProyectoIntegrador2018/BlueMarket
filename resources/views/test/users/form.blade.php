<!-- Name -->
<div class="field {{ $errors->has('name') ? 'has-error' : ''}}">
	<label for="name" class="control-label">{{ 'Name' }}</label>
	<input class="ui input form-control" name="name" type="text" id="name" value="{{ isset($user->name) ? $user->name : ''}}" >
	{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<!-- Email -->
<div class="field {{ $errors->has('email') ? 'has-error' : ''}}">
	<label for="email" class="control-label">{{ 'Email' }}</label>
	<input class="ui input form-control" name="email" type="text" id="email" value="{{ isset($user->email) ? $user->email : ''}}" >
	{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<!-- Role -->
<div class="field {{ $errors->has('role') ? 'has-error' : ''}}">
	<label for="role" class="control-label">{{ 'Role' }}</label>
	<select class="ui dropdown form-control" name="role" id="role" value="{{ isset($user->role) ? $user->role : ''}}">
		<!-- Confirmar con backend -->
		<option value="">Role</option>
		<option value="1">Teacher</option>
		<option value="2">Student</option>
		<option value="3">Administrator</option>
	</select>
	{!! $errors->first('role', '<p class="help-block">:message</p>') !!}
</div>

<br />
