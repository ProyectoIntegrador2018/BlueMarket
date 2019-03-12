
@extends('layouts.app')

@section('title', 'Update profile')

@section('content')
<div class="padded content">
	<h1>Update profile</h1>
	<!-- TODO: add action route -->
	<form class="ui form" {{ $errors->any() ? 'error': '' }}" method="POST" enctype="multipart/form-data">
		<!-- User avatar -->
		<div class="field {{ $errors->has('picture_url') ? 'error': '' }}">
			<label for="avatar">Avatar</label>
			<div class="image-container">
				<div class="image-uploader preview-container">
					<img id="preview" src="<?= Auth::user()->picture_url ?>" alt="User avatar" class="ui small circular image preview"/>
				</div>
				<button type="button" class="ui button primary image-uploader">Upload image</button>
			</div>
			<input id="avatar" type="file" name="avatar" accept="image/png,image/jpeg,image/x-png" onchange="updateImagePreview(this)" style="display: none"/>
		</div>
		<!-- User name -->
		<div class="field {{ $errors->has('name') ? 'error': '' }}">
			<label for="name">Name</label>
			<input type="text" name="name" value="{{ Auth::user()->name }}">
		</div>
		<!-- Skillset -->
		<!-- TODO: receive all skills from backend and pre-select those that the user already has -->
		<!-- TODO: confirm name for back-end error validation for this field -->
		<div class="field {{ $errors->has('tags') ? 'error': '' }}">
			<label for="skills">Skills</label>
			<select id="skills" name="skills[]" class="ui fluid search dropdown" multiple>
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

	let reader = new FileReader();

	// front-end input validation
	$(".ui.form").form({
		fields: {
			name: ["empty", "maxLength[30]"]
		},
		onFailure: function () {
			// onFailure needs to exist to prevent form from sending request
			console.log("failed submission");
			return false;
		},
		onSuccess: function () {
			console.log("ok submission");
		}
	});

	// click on image uploader
	$(".image-uploader").click(function (event) {
		event.preventDefault();
		$("#avatar").click();
	});

	function updateImagePreview(imageInput) {
		let file = imageInput.files[0];
		reader.addEventListener("loadstart", function () {
			const maxImageSize = 1048576; // 1MiB
			// validate file
			if (!file || !isValidImage(file, maxImageSize)) {
				alert("Please upload a .png or .jpeg file.");
				reader.abort();
				return;
			}
		});

		// update preview when completed successfully
		reader.addEventListener("load", function () {
			$("#preview").attr("src", reader.result);
			console.log('this is the result');
			console.log(reader.result);
		});

		reader.readAsDataURL(file);
	}
</script>
@endsection
@endsection
