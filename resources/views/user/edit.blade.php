
@extends('layouts.app')

@section('title', 'Update profile')

@section('content')
<div class="padded content">
	<h1>Update profile</h1>
	<!-- TODO: add action route -->
	<form class="ui form {{ $errors->any() ? 'error': '' }}" method="POST" enctype="multipart/form-data">
		<!-- User avatar -->
		<div class="field {{ $errors->has('picture_url') ? 'error': '' }}">
			<label for="avatar">Avatar</label>
			<div class="image-container">
				<div class="image-uploader preview-container">
					<img id="preview" src="<?= $user->picture_url ?>" alt="User avatar" class="ui small circular image preview"/>
				</div>
				<button type="button" class="ui button primary image-uploader">Upload image</button>
			</div>
			<input id="avatar" type="file" name="avatar" accept="image/png,image/jpeg,image/x-png" onchange="updateImagePreview(this)" style="display: none"/>
		</div>
		<!-- User name -->
		<div class="field {{ $errors->has('name') ? 'error': '' }}">
			<label for="name">Name</label>
			<input type="text" name="name" value="{{ $user->name }}">
		</div>
		<!-- Skillset -->
		<div class="field {{ $errors->has('tags') ? 'error': '' }}">
			<label for="skills">Skills</label>
			@php
				foreach($user->skillset as $user_skill) {
					$user_skills_id[] = $user_skill->tag_id;
				}
			@endphp
			<select id="skills" name="skills[]" class="ui fluid search dropdown" multiple>
				@foreach($skills as $skill)
					@if(in_array($skill->id, $user_skills_id))
						<option value={{ $skill->id }} selected>{{ $skill->name }}</option>
					@else
						<option value={{ $skill->id }}>{{ $skill->name }}</option>
					@endif
				@endforeach
			</select>
		</div>
		<!-- Error message -->
		<div id="errorMessage" class="ui error message">
			<div class="header">Whoops! Something went wrong.</div>
			<p>Please make sure to properly fill out all required fields.</p>
		</div>
		<!-- Save button -->
		<button type="submit" id="saveProfile" class="ui button primary">Save profile</button>
	</form>
</div>

@section('scripts')
<script>
	$( ".ui.fluid.search.dropdown" ).dropdown();

	// front-end input validation
	$(".ui.form").form({
		fields: {
			name: ["empty", "maxLength[30]"]
		},
		onFailure: function () {
			// onFailure needs to exist to prevent form from sending request
			return false;
		}
	});

	// click on image uploader
	$(".image-uploader").click(function (event) {
		event.preventDefault();
		$("#avatar").click();
	});

	function updateImagePreview(imageInput) {
		const reader = new FileReader();

		const file = imageInput.files[0];
		const maxImageSize = 1024*1024*1; // 1MiB

		// validate file
		if (!file || !isValidImage(file, maxImageSize)) {
			alert("Please upload a .png or .jpeg file.");
			return false;
		}

		// update preview when completed successfully
		reader.addEventListener("load", function () {
			$("#preview").attr("src", reader.result);
		});
		reader.readAsDataURL(file);
	}
</script>
@endsection
@endsection
