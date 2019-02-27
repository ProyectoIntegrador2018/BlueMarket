
@extends('layouts.app')

@section('title', 'John Doe')

@section('content')
<div class="padded content">
	<h1>John Doe</h1>
	<div class="ui form error">
		<!-- User image -->
		<div id ="userImage" class="field">
			<label id="userImage" for="userImage">Photo</label>
			<div class="userImageUploaderContainer">
				<div class="imagePreviewContainer">
					<img id="userImagePreview" src="https://lorempixel.com/400/400" alt="User image" class="ui small circular image preview"/>
				</div>
				<a href="#" class="imgUploader">
					<button id="uploadImage" class="ui button primary">Upload image</button>
				</a>
			</div>
			<input id="imgInput" type="file" name="userImage" style="display:none" accept="image/x-png,image/jpeg">
		</div>
		<!-- User name -->
		<div id ="userName" class="field">
			<label id="userName" for="userName">Name</label>
			<input type="text" name="userName" placeholder="John Doe" value="Katie Arriaga">
		</div>
		<!-- User email -->
		<div id="userEmail" class="field">
			<label id="userEmail" for="userEmail">E-mail</label>
			<input type="email" name="userEmail" placeholder="john@example.com" value="katie@example.com">
		</div>
		<!-- Skillset -->
		<div id="skillsets" class="field">
			<label id="skillsets" for="skillsets">Skills</label>
			<select class="ui fluid search dropdown" multiple="">
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
		<button id="saveProfile" class="ui button primary">Save profile</button>
	</div>
</div>

@section('scripts')
<script>
	$('.ui.fluid.search.dropdown')
  		.dropdown();
	$('.imgUploader').click(function(event) {
		event.preventDefault();
		$('#imgInput').click();
	});

	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
				var fileElement = document.getElementById("imgInput");
				var fileExtension = "";
				if (fileElement.value.lastIndexOf(".") > 0) {
					fileExtension = fileElement.value.substring(fileElement.value.lastIndexOf(".") + 1, fileElement.value.length);
				}
				if (fileExtension.toLowerCase() == "png" || fileExtension.toLowerCase() == "jpeg" || fileExtension.toLowerCase() == "jpg") {
                	$('#userImagePreview').attr('src', e.target.result);
				}
				else {
					alert("You must select a JPG or PNG file for upload");
					return false;
				}
            };

			reader.onerror = function (e) {
				alert(e.target.error.name);
			};

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInput").change(function(){
        readURL(this);
    });
</script>
@endsection
@endsection
