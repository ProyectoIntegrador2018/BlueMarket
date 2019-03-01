
@extends('layouts.app')

@section('title', 'John Doe')

@section('content')
<div class="padded content">
	<h1>John Doe</h1>
	<div class="ui form error">
		<!-- User image -->
		<div id ="userImage" class="field">
			<label for="imgInput">Photo</label>
			<div class="userImageUploaderContainer">
				<div class="imgUploader" class="imagePreviewContainer">
					<img id="userImagePreview" src="https://lorempixel.com/400/400" alt="User image" class="ui small circular image preview"/>
				</div>
				<a href="#" class="imgUploader">
					<button type="button" class="ui button primary">Upload image</button>
				</a>
			</div>
			<input id="imgInput" type="file" name="userImage" style="display:none" accept="image/x-png,image/jpeg" onchange="updateImage(this)">
		</div>
		<!-- User name -->
		<div class="field">
			<label for="userName">Name</label>
			<input id="userName" type="text" name="userName" placeholder="John Doe" value="Katie Arriaga">
		</div>
		<!-- User email -->
		<div class="field">
			<label for="userEmail">E-mail</label>
			<input id="userEmail" type="email" name="userEmail" placeholder="john@example.com" value="katie@example.com">
		</div>
		<!-- Skillset -->
		<div class="field">
			<label for="skillsets">Skills</label>
			<select id="skillsets" class="ui fluid search dropdown" multiple>
				<option value="">Skills</option>
				<option value="angular">Angular</option>
				<option value="css">CSS</option>
				<option value="design">Graphic Design</option>
				<option value="ember">Ember</option>
				<option value="html">HTML</option>
				<option value="ia">Information Architecture</option>
				<option value="javascript">Javascript</option>
				<option value="mech">Mechanical Engineering</option>
				<option value="meteor">Meteor</option>
				<option value="node">NodeJS</option>
				<option value="plumbing">Plumbing</option>
				<option value="python">Python</option>
				<option value="rails">Rails</option>
				<option value="react">React</option>
				<option value="repair">Kitchen Repair</option>
				<option value="ruby">Ruby</option>
				<option value="ui">UI Design</option>
				<option value="ux">User Experience</option>
			</select>
		</div>
		<!-- Error message -->
		<div id="errorMessage" class="ui error message hidden">
			<div class="header">Whoops! Something went wrong.</div>
			<p>Please make sure to properly fill out all required fields.</p>
		</div>
		<!-- Save button -->
		<button type="submit" id="saveProfile" class="ui button primary">Save profile</button>
	</div>
</div>

@section('scripts')
<script>
	$( ".ui.fluid.search.dropdown" ).dropdown();

	$( ".imgUploader" ).click(function(event) {
		event.preventDefault();
		$( "#imgInput" ).click();
	});

	function validateImage(file) {
		const maxImageSize = 1000000; // 1MB

		if ((file.type == "image/png" || file.type == "image/jpeg" || file.type == "image/jpg") && file.size <= maxImageSize) {
			return true;
		}
		else {
			return false;
		}
	}

	function updateImage(imageInput) {
		let reader  = new FileReader();
		let file = imageInput.files[0];
		let preview = $( "#userImagePreview" );

		reader.addEventListener("load", function () {
			if(validateImage(file)) {
				$( "#userImagePreview" ).attr("src", reader.result);
			}
		});

		if (file) {
			reader.readAsDataURL(file);
		}
	}

</script>
@endsection
@endsection
