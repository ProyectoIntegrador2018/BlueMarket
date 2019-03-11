<div id ="image" class="field">
	<label for="teamImage">Team image</label>
	<div class="image-container">
		<div class="image-uploader preview-container">
			<img id="preview" src="{{ isset($image) ? $image : 'https://avatars1.githubusercontent.com/u/42351872?s=200&v=4' }}" alt="Team image" class="ui small image preview"/>
		</div>
		<button type="button" class="ui button primary image-uploader">Upload image</button>
	</div>
	<input id="teamImage" type="file" name="teamImage" accept="image/png,image/jpeg,image/x-png" onchange="updateImagePreview(this)" style="display: none"/>
</div>
<!-- Team name -->
<div class="field {{ $errors->has('name') ? 'error': '' }}">
	<label for="teamName">Team name</label>
	<input type="text" name="teamName" id="teamName" value="{{ isset($teamName) ? $teamName : '' }}"/>
</div>
<!-- Error message -->
<div id="errorMessage" class="ui error message">
	<div class="header">Whoops! Something went wrong.</div>
	<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
