<!-- Name -->
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
	<label for="name" class="control-label">{{ 'Name' }}</label>
	<input class="form-control" name="name" type="text" id="name" value="{{ isset($user->name) ? $user->name : ''}}" >
	{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<!-- Email -->
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
	<label for="email" class="control-label">{{ 'Email' }}</label>
	<input class="form-control" name="email" type="text" id="email" value="{{ isset($user->email) ? $user->email : ''}}" >
	{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<!-- Role -->
<div class="form-group {{ $errors->has('role') ? 'has-error' : ''}}">
	<label for="role" class="control-label">{{ 'Role' }}</label>
	<select class="form-control" name="role" id="role">
		<option value="">Role</option>
		<option {{ isset($user) && $user->role == 1 ? 'selected' : ''}} value="1">Administrator</option>
		<option {{ isset($user) && $user->role == 2 ? 'selected' : ''}} value="2">Teacher</option>
		<option {{ isset($user) && $user->role == 3 ? 'selected' : ''}} value="3">Student</option>
	</select>
	{!! $errors->first('role', '<p class="help-block">:message</p>') !!}
</div>
