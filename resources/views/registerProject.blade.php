<!--
	Falta:
		1. Validar que imagen no pase de 1MB (ya está el código pero entoy teniendo problema para que funcione.)
		2. DropDown que utiliza el AJAX call para que se conecte con los team members (Ana Karen)
-->

@extends('layouts.app')

@section('title', 'Add Project')

@section('content')

@section('header', 'Register a new project')

<div class="ui container" style="margin: 4% auto 8%">
	<div class="ui grid centered">
		<div class="ten wide column">
			<div class="ui form error">
				<!-- Alert Message -->
				<div id="errorMessage" class="ui error message hidden">
					<div class="header">Register Error</div>
					<p>All fields are required for registering a new project.</p>
				</div>
				<!-- Project Image -->
				<div class="projectImg">
					<label for="projectImg">Project Image</label>
					<div id="errorMessage" class="ui error message hidden">
						<div class="header">Image Error</div>
						<p>The image should not exceed 1 MB.</p>
					</div>
					<img src="https://lorempixel.com/400/400" alt="Project Image" class="ui medium image" name="projectImg" id="userImagePreview" />
					<a href="#" class="imgUploader">
						<button id="uploadImage" class="ui left floated button primary">Upload Image</button>
					</a>
					<input type="file" id="imgInput" style="display:none" multiple accept='image/*'>
				</div>
				<!-- Project Name -->
				<div id ="projectName" class="field">
					<label for="proyectName">Project Name</label>
					<input id="projectName2" type="text" name="projectName" placeholder="Enter your project's name...">
				</div>
				<!-- Team Name -->
				<div id="teamName" class="field">
					<label for="teamName">Team Name</label>
					<input id="teamName2" type="text" name="teamName" placeholder="Enter your team's name...">
				</div>
				<!-- Category -->
				<div id ="category" class="field">
					<label for="category">Category</label>
					<select name="category" class="ui search dropdown" placeholder="Select your project's category" id="category2">
						<option style="color:grey;" value="0">Select your project's category</option>
						<option value="1">Category 1</option>
						<option value="2">Category 2</option>
						<option value="3">Category 3</option>
					</select>
				</div>
				<!-- Skillset -->
				<div id="skillsets" class="field">
					<label for="skillsets">Required Skillsets</label>
					<div class="ui search">
						<div class="ui icon input">
							<input id="skillsets2" name="skillsets" class="prompt" type="text" placeholder="Search and add skillsets...">
							<i class="search icon"></i>
						</div>
						<div class="results">
						</div>
					</div>
				</div>
				<!-- Milestones -->
				<div id="milestones" class="field">
					<label for="milestones">Public Milestones</label>
					<input id="milestones2" type="text" name="milestones" placeholder="Example: Shipping">
				</div>
				<!-- Short Description -->
				<div id="shortDescription" class="field">
					<label>Brief Description</label>
					<textarea id="shortDescription2" rows="2"></textarea>
				</div>
				<!-- Long Description -->
				<div id="longDescription" class="field">
					<label>Detailed Description</label>
					<textarea id="longDescription2"></textarea>
				</div>
				<!-- Video Pitch -->
				<div id="videoPitch" class="field">
					<label>Pitch Video</label>
					<input id="videoPitch2" type="text" name="milestones" placeholder="Example: https://youtube.com/watch?v=238028302">
				</div>
				<!-- Register Button -->
				<button id="registerProject" class="ui left floated button primary">Register project</button>
			</div>
		</div>
	</div>
</div>

@section('jquery')
<!-- Internal jQuery -->
<script>
	/* Search for skillsets */
	var skillsets = [
		{ title: 'Skillset 1' },
		{ title: 'Skillset 2' },
		{ title: 'Skillset 3' },
		{ title: 'Skillset 4' },
		{ title: 'Skillset 5' },
	];
	$('.ui.search').search({source: skillsets});
	$('.ui.search.category.dropdown').dropdown({useLabels: false});
	$('.imgUploader').click(function(event) {
		event.preventDefault();
		$('#imgInput').click();
	});

	/* Upload new image */
	function readURL(input){
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#userImagePreview').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imgInput").change(function(){
	    readURL(this);
	});

	/* Register button click */
	$('#registerProject').on('click', function(event){
		event.preventDefault();
		//Alert Message
		let $errorMessage = $('#errorMessage');
		// Image
		/*let $fileSize = $('#imgInput')[0].files[0].size;
		if($fileSize > 300){//1000000){
			$errorMessage.removeClass('hidden');
			//return false;
		}*/
		// Project Name
		let $projectName = $('#projectName');
		let $projectName2 = $('#projectName2');
		if($projectName2.val() == ""){
			$projectName.addClass('field error');
			$errorMessage.removeClass('hidden');
			$("html, body").animate({scrollTop: 0}, "slow");
		}
		// Team Name
		let $teamName = $('#teamName');
		let $teamName2 = $('#teamName2');
		if($teamName2.val() == ""){
			$teamName.addClass('field error');
			$errorMessage.removeClass('hidden');
			$("html, body").animate({scrollTop: 0}, "slow");
		}
		// Category Dropdown
		let $category = $("#category");
		let $category2 = $('#category2');
		if($category2.val() == '0'){
			$category.addClass('field error');
			$errorMessage.removeClass('hidden');
			$("html, body").animate({scrollTop: 0}, "slow");
		}
		// Skillsets
		let $skillsets = $('#skillsets');
		let $skillsets2 = $('#skillsets2');
		if($skillsets2.val() == ""){
			$skillsets.addClass('field error');
			$errorMessage.removeClass('hidden');
			$("html, body").animate({scrollTop: 0}, "slow");
		}
		// Public Milestones
		let $milestones = $('#milestones');
		let $milestones2 = $('#milestones2');
		if($milestones2.val() == ""){
			$milestones.addClass('field error');
			$errorMessage.removeClass('hidden');
			$("html, body").animate({scrollTop: 0}, "slow");
		}
		// Short Description
		let $shortDescription = $('#shortDescription');
		let $shortDescription2 = $('#shortDescription2');
		if($shortDescription2.val() == ""){
			$shortDescription.addClass('field error');
			$errorMessage.removeClass('hidden');
			$("html, body").animate({scrollTop: 0}, "slow");
		}
		// Long Description
		let $longDescription = $('#longDescription');
		let $longDescription2 = $('#longDescription2');
		if($longDescription2.val() == ""){
			$longDescription.addClass('field error');
			$errorMessage.removeClass('hidden');
			$("html, body").animate({scrollTop: 0}, "slow");
		}
		// Pitch Video
		let $videoPitch = $('#videoPitch');
		let $videoPitch2 = $('#videoPitch2');
		if($videoPitch2.val() == ""){
			$videoPitch.addClass('field error');
			$errorMessage.removeClass('hidden');
			$("html, body").animate({scrollTop: 0}, "slow");
		}
	});
</script>
@endsection
@endsection
